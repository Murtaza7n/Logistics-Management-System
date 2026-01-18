<?php

namespace App\Http\Controllers;

use App\Models\VehicleLoadPlan;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Shipment;
use App\Models\City;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleLoadPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = VehicleLoadPlan::with(['vehicle', 'driver', 'creator', 'shipments'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('from_city')) {
            $query->where('from_city', $request->from_city);
        }

        if ($request->filled('to_city')) {
            $query->where('to_city', $request->to_city);
        }

        $loadPlans = $query->paginate(15);
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $drivers = Driver::where('status', 'available')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('vehicle-load-plans.index', compact('loadPlans', 'vehicles', 'drivers', 'cities'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $drivers = Driver::where('status', 'available')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $shipments = Shipment::where('status', 'booked')->orWhere('status', 'picked-up')->get();
        $systemYear = session('system_year', '2526');

        return view('vehicle-load-plans.create', compact('vehicles', 'drivers', 'cities', 'shipments', 'systemYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'from_city' => 'required|string|max:100',
            'to_city' => 'required|string|max:100',
            'planned_departure_date' => 'nullable|date',
            'planned_arrival_date' => 'nullable|date',
            'status' => 'required|in:planned,in-transit,received,completed,cancelled',
            'shipment_ids' => 'nullable|array',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
        ]);

        // Generate plan number
        $systemYear = session('system_year', '2526');
        $planNumber = 'VLP-' . $systemYear . '-' . strtoupper(Str::random(6));
        
        while (VehicleLoadPlan::where('plan_number', $planNumber)->exists()) {
            $planNumber = 'VLP-' . $systemYear . '-' . strtoupper(Str::random(6));
        }

        $validated['plan_number'] = $planNumber;
        $validated['system_year'] = $systemYear;
        $validated['created_by'] = auth()->id();

        $loadPlan = VehicleLoadPlan::create($validated);

        // Attach shipments if provided
        if ($request->filled('shipment_ids')) {
            $shipments = [];
            foreach ($request->shipment_ids as $index => $shipmentId) {
                $shipments[$shipmentId] = ['sequence' => $index + 1, 'status' => 'loaded'];
            }
            $loadPlan->shipments()->attach($shipments);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'VehicleLoadPlan',
            'model_id' => $loadPlan->load_plan_id,
            'description' => "Created vehicle load plan: {$loadPlan->plan_number}",
        ]);

        return redirect()->route('vehicle-load-plans.index')->with('success', 'Vehicle Load Plan created successfully.');
    }

    public function show(VehicleLoadPlan $vehicleLoadPlan)
    {
        $vehicleLoadPlan->load(['vehicle', 'driver', 'creator', 'shipments']);
        return view('vehicle-load-plans.show', compact('vehicleLoadPlan'));
    }

    public function edit(VehicleLoadPlan $vehicleLoadPlan)
    {
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $drivers = Driver::where('status', 'available')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $shipments = Shipment::where('status', 'booked')->orWhere('status', 'picked-up')->get();
        $vehicleLoadPlan->load('shipments');
        
        return view('vehicle-load-plans.edit', compact('vehicleLoadPlan', 'vehicles', 'drivers', 'cities', 'shipments'));
    }

    public function update(Request $request, VehicleLoadPlan $vehicleLoadPlan)
    {
        $validated = $request->validate([
            'plan_date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'from_city' => 'required|string|max:100',
            'to_city' => 'required|string|max:100',
            'planned_departure_date' => 'nullable|date',
            'planned_arrival_date' => 'nullable|date',
            'actual_departure_date' => 'nullable|date',
            'actual_arrival_date' => 'nullable|date',
            'status' => 'required|in:planned,in-transit,received,completed,cancelled',
            'shipment_ids' => 'nullable|array',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
        ]);

        $vehicleLoadPlan->update($validated);

        // Update shipments if provided
        if ($request->has('shipment_ids')) {
            $shipments = [];
            foreach ($request->shipment_ids as $index => $shipmentId) {
                $shipments[$shipmentId] = ['sequence' => $index + 1, 'status' => 'loaded'];
            }
            $vehicleLoadPlan->shipments()->sync($shipments);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'VehicleLoadPlan',
            'model_id' => $vehicleLoadPlan->load_plan_id,
            'description' => "Updated vehicle load plan: {$vehicleLoadPlan->plan_number}",
        ]);

        return redirect()->route('vehicle-load-plans.index')->with('success', 'Vehicle Load Plan updated successfully.');
    }

    public function destroy(VehicleLoadPlan $vehicleLoadPlan)
    {
        $planNumber = $vehicleLoadPlan->plan_number;
        $vehicleLoadPlan->shipments()->detach();
        $vehicleLoadPlan->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'VehicleLoadPlan',
            'model_id' => $vehicleLoadPlan->load_plan_id,
            'description' => "Deleted vehicle load plan: {$planNumber}",
        ]);

        return redirect()->route('vehicle-load-plans.index')->with('success', 'Vehicle Load Plan deleted successfully.');
    }

    public function received()
    {
        $loadPlans = VehicleLoadPlan::with(['vehicle', 'driver', 'shipments'])
            ->where('status', 'received')
            ->orWhere('status', 'completed')
            ->latest()
            ->paginate(15);

        return view('vehicle-load-plans.received', compact('loadPlans'));
    }
}
