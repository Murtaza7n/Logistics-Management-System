<?php

namespace App\Http\Controllers;

use App\Models\PickupSheet;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\City;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PickupSheetController extends Controller
{
    public function index(Request $request)
    {
        $query = PickupSheet::with(['driver', 'vehicle', 'creator', 'bookings'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('pickup_city')) {
            $query->where('pickup_city', $request->pickup_city);
        }

        $pickupSheets = $query->paginate(15);
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('pickup-sheets.index', compact('pickupSheets', 'drivers', 'vehicles', 'cities'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $bookings = Booking::where('status', 'pending')->orWhere('status', 'confirmed')->get();
        $systemYear = session('system_year', '2526');

        return view('pickup-sheets.create', compact('drivers', 'vehicles', 'cities', 'bookings', 'systemYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sheet_date' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'pickup_city' => 'required|string|max:100',
            'pickup_date' => 'required|date',
            'status' => 'required|in:prepared,out-for-pickup,completed,cancelled',
            'booking_ids' => 'nullable|array',
            'booking_ids.*' => 'exists:bookings,booking_id',
        ]);

        // Generate sheet number
        $systemYear = session('system_year', '2526');
        $sheetNumber = 'PS-' . $systemYear . '-' . strtoupper(Str::random(6));
        
        while (PickupSheet::where('sheet_number', $sheetNumber)->exists()) {
            $sheetNumber = 'PS-' . $systemYear . '-' . strtoupper(Str::random(6));
        }

        $validated['sheet_number'] = $sheetNumber;
        $validated['system_year'] = $systemYear;
        $validated['created_by'] = auth()->id();
        $validated['total_bookings'] = count($request->booking_ids ?? []);
        $validated['pending_count'] = count($request->booking_ids ?? []);

        $pickupSheet = PickupSheet::create($validated);

        // Attach bookings if provided
        if ($request->filled('booking_ids')) {
            $bookings = [];
            foreach ($request->booking_ids as $index => $bookingId) {
                $bookings[$bookingId] = [
                    'sequence' => $index + 1,
                    'pickup_status' => 'pending'
                ];
            }
            $pickupSheet->bookings()->attach($bookings);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'PickupSheet',
            'model_id' => $pickupSheet->pickup_sheet_id,
            'description' => "Created pickup sheet: {$pickupSheet->sheet_number}",
        ]);

        return redirect()->route('pickup-sheets.index')->with('success', 'Pickup Sheet created successfully.');
    }

    public function show(PickupSheet $pickupSheet)
    {
        $pickupSheet->load(['driver', 'vehicle', 'creator', 'bookings']);
        return view('pickup-sheets.show', compact('pickupSheet'));
    }

    public function edit(PickupSheet $pickupSheet)
    {
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $bookings = Booking::where('status', 'pending')->orWhere('status', 'confirmed')->get();
        $pickupSheet->load('bookings');
        
        return view('pickup-sheets.edit', compact('pickupSheet', 'drivers', 'vehicles', 'cities', 'bookings'));
    }

    public function update(Request $request, PickupSheet $pickupSheet)
    {
        $validated = $request->validate([
            'sheet_date' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'pickup_city' => 'required|string|max:100',
            'pickup_date' => 'required|date',
            'status' => 'required|in:prepared,out-for-pickup,completed,cancelled',
            'booking_ids' => 'nullable|array',
            'booking_ids.*' => 'exists:bookings,booking_id',
        ]);

        $validated['total_bookings'] = count($request->booking_ids ?? []);
        $pickupSheet->update($validated);

        // Update bookings if provided
        if ($request->has('booking_ids')) {
            $bookings = [];
            foreach ($request->booking_ids as $index => $bookingId) {
                $bookings[$bookingId] = [
                    'sequence' => $index + 1,
                    'pickup_status' => 'pending'
                ];
            }
            $pickupSheet->bookings()->sync($bookings);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'PickupSheet',
            'model_id' => $pickupSheet->pickup_sheet_id,
            'description' => "Updated pickup sheet: {$pickupSheet->sheet_number}",
        ]);

        return redirect()->route('pickup-sheets.index')->with('success', 'Pickup Sheet updated successfully.');
    }

    public function destroy(PickupSheet $pickupSheet)
    {
        $sheetNumber = $pickupSheet->sheet_number;
        $pickupSheet->bookings()->detach();
        $pickupSheet->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'PickupSheet',
            'model_id' => $pickupSheet->pickup_sheet_id,
            'description' => "Deleted pickup sheet: {$sheetNumber}",
        ]);

        return redirect()->route('pickup-sheets.index')->with('success', 'Pickup Sheet deleted successfully.');
    }
}
