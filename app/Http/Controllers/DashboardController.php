<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\City;
use App\Models\User;
use App\Models\CNBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $sevenDaysAgo = now()->subDays(7)->toDateString();
        
        // Get accessible cities based on user permissions
        $accessibleCityIds = $user->isAdmin() 
            ? City::where('is_active', true)->pluck('city_id')->toArray()
            : $user->accessibleCities()->pluck('city_id')->toArray();
        
        // Base query with city permission filter
        $baseQuery = Shipment::query();
        if (!$user->isAdmin() && !empty($accessibleCityIds)) {
            $baseQuery->whereIn('entry_city', $accessibleCityIds);
        }
        
        // 1. Top Summary Cards (5 ONLY)
        $stats = [
            'today_cn_entries' => (clone $baseQuery)->whereDate('created_at', $today)->count(),
            'pending_deliveries' => (clone $baseQuery)->whereIn('status', ['in-transit', 'out-for-delivery', 'booked', 'picked-up'])->count(),
            'delivered_today' => (clone $baseQuery)->where('status', 'delivered')->whereDate('actual_delivery_date', $today)->count(),
            'delayed_shipments' => (clone $baseQuery)->whereIn('status', ['in-transit', 'out-for-delivery', 'booked', 'picked-up'])
                ->whereNotNull('delivery_date')
                ->where('delivery_date', '<', $today)
                ->count(),
            'active_cities' => count($accessibleCityIds),
        ];
        
        // 2. City-Wise Workload (for bar chart)
        $cityWorkload = City::whereIn('city_id', $accessibleCityIds)
            ->where('is_active', true)
            ->get()
            ->map(function ($city) use ($baseQuery) {
                $cityQuery = (clone $baseQuery)->where('entry_city', $city->city_id);
                return [
                    'city_id' => $city->city_id,
                    'name' => $city->name,
                    'code' => $city->code,
                    'total_cns' => $cityQuery->count(),
                    'pending_cns' => $cityQuery->whereIn('status', ['in-transit', 'out-for-delivery', 'booked', 'picked-up'])->count(),
                ];
            })
            ->sortByDesc('total_cns')
            ->values();
        
        // 3. Top 10 Problem CNs (Pending/Delayed)
        $problemCns = (clone $baseQuery)
            ->whereIn('status', ['in-transit', 'out-for-delivery', 'booked', 'picked-up'])
            ->where(function($q) use ($today) {
                $q->whereNull('delivery_date')
                  ->orWhere('delivery_date', '<', $today);
            })
            ->with(['customer', 'entryCity'])
            ->orderByRaw('CASE WHEN delivery_date IS NULL THEN 1 ELSE 0 END, delivery_date ASC')
            ->limit(10)
            ->get()
            ->map(function ($shipment) use ($today) {
                $shipment->is_delayed = $shipment->delivery_date && $shipment->delivery_date < $today;
                $shipment->days_delayed = $shipment->delivery_date 
                    ? max(0, now()->diffInDays($shipment->delivery_date, false)) 
                    : null;
                return $shipment;
            });
        
        // 4. CN Trend (Last 7 days only)
        $cnTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = (clone $baseQuery)->whereDate('created_at', $date)->count();
            $cnTrend[] = [
                'date' => $date,
                'day' => now()->subDays($i)->format('D'),
                'count' => $count,
            ];
        }
        
        // 5. Staff Overview
        $staffOverview = [
            'total_staff' => $user->isAdmin() 
                ? User::whereIn('role', ['staff', 'driver'])->count()
                : User::whereIn('role', ['staff', 'driver'])
                    ->where(function($q) use ($accessibleCityIds) {
                        $q->whereIn('primary_city_id', $accessibleCityIds)
                          ->orWhereHas('cityPermissions', function($q) use ($accessibleCityIds) {
                              $q->whereIn('city_id', $accessibleCityIds);
                          });
                    })->count(),
            'active_staff' => $user->isAdmin()
                ? User::whereIn('role', ['staff', 'driver'])->count() // Assuming all are active
                : User::whereIn('role', ['staff', 'driver'])
                    ->where(function($q) use ($accessibleCityIds) {
                        $q->whereIn('primary_city_id', $accessibleCityIds)
                          ->orWhereHas('cityPermissions', function($q) use ($accessibleCityIds) {
                              $q->whereIn('city_id', $accessibleCityIds);
                          });
                    })->count(),
        ];
        
        // City-wise staff count
        $cityWiseStaff = City::whereIn('city_id', $accessibleCityIds)
            ->where('is_active', true)
            ->get()
            ->map(function ($city) use ($user) {
                if ($user->isAdmin()) {
                    $staff = User::whereIn('role', ['staff', 'driver'])
                        ->where(function($q) use ($city) {
                            $q->where('primary_city_id', $city->city_id)
                              ->orWhereHas('cityPermissions', function($q) use ($city) {
                                  $q->where('city_id', $city->city_id);
                              });
                        })->get();
                } else {
                    $staff = User::whereIn('role', ['staff', 'driver'])
                        ->whereHas('cityPermissions', function($q) use ($city) {
                            $q->where('city_id', $city->city_id);
                        })->get();
                }
                
                return [
                    'city_id' => $city->city_id,
                    'name' => $city->name,
                    'code' => $city->code,
                    'staff_count' => $staff->count(),
                ];
            })
            ->filter(function($item) {
                return $item['staff_count'] > 0;
            })
            ->values();
        
        // 6. Alerts Panel
        $alerts = [];
        
        // CN Book running low
        $lowCnBooks = CNBook::where('status', 'active')
            ->get()
            ->filter(function ($book) {
                return $book->isLowStock();
            });
        
        if ($lowCnBooks->count() > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'bi-exclamation-triangle',
                'message' => $lowCnBooks->count() . ' CN Book(s) running low on stock',
                'count' => $lowCnBooks->count(),
            ];
        }
        
        // High pending deliveries in any city
        $highPendingCities = $cityWorkload->filter(function($city) {
            return $city['pending_cns'] > 20; // Threshold: more than 20 pending
        });
        
        if ($highPendingCities->count() > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'bi-clock-history',
                'message' => $highPendingCities->count() . ' City/Cities with high pending deliveries (>20)',
                'count' => $highPendingCities->count(),
            ];
        }
        
        // Delayed shipments alert
        if ($stats['delayed_shipments'] > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'bi-x-circle',
                'message' => $stats['delayed_shipments'] . ' Delayed shipment(s) require attention',
                'count' => $stats['delayed_shipments'],
            ];
        }
        
        return view('dashboard', compact(
            'stats',
            'cityWorkload',
            'problemCns',
            'cnTrend',
            'staffOverview',
            'cityWiseStaff',
            'alerts'
        ));
    }
}
