<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('driver')->latest()->paginate(15);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'registration_no' => 'required|string|unique:vehicles,registration_no',
            'make' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'capacity' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,in-use,maintenance,retired',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $vehicle = Vehicle::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Vehicle',
            'model_id' => $vehicle->vehicle_id,
            'description' => "Created vehicle: {$vehicle->registration_no}",
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['driver', 'shipments']);
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'registration_no' => 'required|string|unique:vehicles,registration_no,' . $vehicle->vehicle_id . ',vehicle_id',
            'make' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'capacity' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,in-use,maintenance,retired',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $vehicle->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Vehicle',
            'model_id' => $vehicle->vehicle_id,
            'description' => "Updated vehicle: {$vehicle->registration_no}",
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $reg_no = $vehicle->registration_no;
        $vehicle->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Vehicle',
            'model_id' => $vehicle->vehicle_id,
            'description' => "Deleted vehicle: {$reg_no}",
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}


