<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('vehicle')->latest()->paginate(15);
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('drivers.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_no' => 'required|string|unique:drivers,license_no',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'assigned_vehicle' => 'nullable|exists:vehicles,vehicle_id',
            'license_expiry' => 'nullable|date',
            'status' => 'required|in:available,on-trip,off-duty,suspended',
        ]);

        $driver = Driver::create($validated);

        // Update vehicle status if assigned
        if ($driver->assigned_vehicle) {
            Vehicle::where('vehicle_id', $driver->assigned_vehicle)->update(['status' => 'in-use']);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Driver',
            'model_id' => $driver->driver_id,
            'description' => "Created driver: {$driver->name}",
        ]);

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver)
    {
        $driver->load(['vehicle', 'shipments']);
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $vehicles = Vehicle::all();
        return view('drivers.edit', compact('driver', 'vehicles'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_no' => 'required|string|unique:drivers,license_no,' . $driver->driver_id . ',driver_id',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'assigned_vehicle' => 'nullable|exists:vehicles,vehicle_id',
            'license_expiry' => 'nullable|date',
            'status' => 'required|in:available,on-trip,off-duty,suspended',
        ]);

        $old_vehicle_id = $driver->assigned_vehicle;

        $driver->update($validated);

        // Update vehicle status
        if ($old_vehicle_id != $driver->assigned_vehicle) {
            if ($old_vehicle_id) {
                Vehicle::where('vehicle_id', $old_vehicle_id)->update(['status' => 'available']);
            }
            if ($driver->assigned_vehicle) {
                Vehicle::where('vehicle_id', $driver->assigned_vehicle)->update(['status' => 'in-use']);
            }
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Driver',
            'model_id' => $driver->driver_id,
            'description' => "Updated driver: {$driver->name}",
        ]);

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $name = $driver->name;
        $driver->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Driver',
            'model_id' => $driver->driver_id,
            'description' => "Deleted driver: {$name}",
        ]);

        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}


