<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of cities
     */
    public function index(Request $request)
    {
        $query = City::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $cities = $query->orderBy('name')->get();

        return view('reports.list_of_city_codes', compact('cities'));
    }

    /**
     * Store a newly created city
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
            'code' => 'nullable|string|max:10|unique:cities,code',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'City name is required.',
            'name.unique' => 'A city with this name already exists.',
            'code.unique' => 'A city with this code already exists.',
        ]);

        $city = City::create([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? 'Pakistan',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('cities.index')
            ->with('success', "City '{$city->name}' has been added successfully.");
    }

    /**
     * Remove the specified city
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        // Check if city is in use
        $shipmentsCount = Shipment::where('entry_city', $city->city_id)->count();

        if ($shipmentsCount > 0) {
            return redirect()->route('cities.index')
                ->with('error', "Cannot delete city '{$city->name}' because it is being used in {$shipmentsCount} shipment(s). Please deactivate it instead.");
        }

        $cityName = $city->name;
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', "City '{$cityName}' has been deleted successfully.");
    }

    /**
     * Toggle city active status
     */
    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->is_active = !$city->is_active;
        $city->save();

        $status = $city->is_active ? 'activated' : 'deactivated';
        return redirect()->route('cities.index')
            ->with('success', "City '{$city->name}' has been {$status} successfully.");
    }

    /**
     * Switch selected city (for city selector)
     */
    public function switchCity(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,city_id',
        ]);

        $user = auth()->user();
        $cityId = $request->input('city_id');

        // Check permission (admin can access all cities)
        if (!$user->isAdmin() && !$user->hasCityPermission($cityId, 'view')) {
            return back()->with('error', 'You do not have permission to access this city.');
        }

        // Set selected city in session
        session(['selected_city_id' => $cityId]);

        return back()->with('success', 'City switched successfully.');
    }

    /**
     * Get accessible cities for current user (API endpoint)
     */
    public function getAccessibleCities()
    {
        $user = auth()->user();
        $cities = $user->accessibleCities();
        
        return response()->json($cities);
    }
}

