<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('shipment_number')) {
            $query->where('shipment_number', 'like', '%' . $request->shipment_number . '%');
        }

        $shipments = $query->paginate(15);
        $customers = Customer::where('status', 'active')->get();

        return view('shipments.index', compact('shipments', 'customers'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'available')->get();
        $drivers = Driver::where('status', 'available')->get();

        return view('shipments.create', compact('customers', 'vendors', 'vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_number' => 'required|string|unique:shipments,shipment_number',
            'customer_id' => 'required|exists:customers,customer_id',
            'vendor_id' => 'nullable|exists:vendors,vendor_id',
            'sender' => 'required|string',
            'receiver' => 'required|string',
            'sender_contact' => 'nullable|string',
            'receiver_contact' => 'nullable|string',
            'pickup_city' => 'required|string',
            'delivery_city' => 'required|string',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'cargo_type' => 'required|string',
            'weight' => 'nullable|numeric|min:0',
            'dimension' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
            'freight_charges' => 'nullable|numeric|min:0',
            'labor_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'status' => 'required|in:booked,picked-up,in-transit,out-for-delivery,delivered,cancelled',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'pickup_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $shipment = Shipment::create($validated);

        // Update vehicle and driver status if assigned
        if ($shipment->vehicle_id) {
            Vehicle::where('vehicle_id', $shipment->vehicle_id)->update(['status' => 'in-use']);
        }
        if ($shipment->driver_id) {
            Driver::where('driver_id', $shipment->driver_id)->update(['status' => 'on-trip']);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Shipment',
            'model_id' => $shipment->shipment_id,
            'description' => "Created shipment: {$shipment->shipment_number}",
        ]);

        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['customer', 'vendor', 'vehicle', 'driver', 'invoices']);
        return view('shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('shipments.edit', compact('shipment', 'customers', 'vendors', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'shipment_number' => 'required|string|unique:shipments,shipment_number,' . $shipment->shipment_id . ',shipment_id',
            'customer_id' => 'required|exists:customers,customer_id',
            'vendor_id' => 'nullable|exists:vendors,vendor_id',
            'sender' => 'required|string',
            'receiver' => 'required|string',
            'sender_contact' => 'nullable|string',
            'receiver_contact' => 'nullable|string',
            'pickup_city' => 'required|string',
            'delivery_city' => 'required|string',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'cargo_type' => 'required|string',
            'weight' => 'nullable|numeric|min:0',
            'dimension' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
            'freight_charges' => 'nullable|numeric|min:0',
            'labor_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'status' => 'required|in:booked,picked-up,in-transit,out-for-delivery,delivered,cancelled',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'pickup_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'actual_delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $old_vehicle_id = $shipment->vehicle_id;
        $old_driver_id = $shipment->driver_id;

        $shipment->update($validated);

        // Update vehicle status
        if ($old_vehicle_id != $shipment->vehicle_id) {
            if ($old_vehicle_id) {
                Vehicle::where('vehicle_id', $old_vehicle_id)->update(['status' => 'available']);
            }
            if ($shipment->vehicle_id) {
                Vehicle::where('vehicle_id', $shipment->vehicle_id)->update(['status' => 'in-use']);
            }
        }

        // Update driver status
        if ($old_driver_id != $shipment->driver_id) {
            if ($old_driver_id) {
                Driver::where('driver_id', $old_driver_id)->update(['status' => 'available']);
            }
            if ($shipment->driver_id) {
                Driver::where('driver_id', $shipment->driver_id)->update(['status' => 'on-trip']);
            }
        }

        // If delivered, update vehicle and driver to available
        if ($shipment->status === 'delivered') {
            if ($shipment->vehicle_id) {
                Vehicle::where('vehicle_id', $shipment->vehicle_id)->update(['status' => 'available']);
            }
            if ($shipment->driver_id) {
                Driver::where('driver_id', $shipment->driver_id)->update(['status' => 'available']);
            }
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Shipment',
            'model_id' => $shipment->shipment_id,
            'description' => "Updated shipment: {$shipment->shipment_number}",
        ]);

        return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $number = $shipment->shipment_number;
        $shipment->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Shipment',
            'model_id' => $shipment->shipment_id,
            'description' => "Deleted shipment: {$number}",
        ]);

        return redirect()->route('shipments.index')->with('success', 'Shipment deleted successfully.');
    }
}


