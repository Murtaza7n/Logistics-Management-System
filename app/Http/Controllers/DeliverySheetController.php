<?php

namespace App\Http\Controllers;

use App\Models\DeliverySheet;
use App\Models\Shipment;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\City;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliverySheetController extends Controller
{
    public function index(Request $request)
    {
        $query = DeliverySheet::with(['driver', 'vehicle', 'creator', 'shipments'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('delivery_city')) {
            $query->where('delivery_city', $request->delivery_city);
        }

        $deliverySheets = $query->paginate(15);
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('delivery-sheets.index', compact('deliverySheets', 'drivers', 'vehicles', 'cities'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $shipments = Shipment::where('status', 'in-transit')
            ->orWhere('status', 'out-for-delivery')
            ->get();
        $systemYear = session('system_year', '2526');

        return view('delivery-sheets.create', compact('drivers', 'vehicles', 'cities', 'shipments', 'systemYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sheet_date' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'delivery_city' => 'required|string|max:100',
            'delivery_date' => 'required|date',
            'status' => 'required|in:prepared,out-for-delivery,completed,cancelled',
            'shipment_ids' => 'nullable|array',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
        ]);

        // Generate sheet number
        $systemYear = session('system_year', '2526');
        $sheetNumber = 'DS-' . $systemYear . '-' . strtoupper(Str::random(6));
        
        while (DeliverySheet::where('sheet_number', $sheetNumber)->exists()) {
            $sheetNumber = 'DS-' . $systemYear . '-' . strtoupper(Str::random(6));
        }

        $validated['sheet_number'] = $sheetNumber;
        $validated['system_year'] = $systemYear;
        $validated['created_by'] = auth()->id();
        $validated['total_shipments'] = count($request->shipment_ids ?? []);
        $validated['pending_count'] = count($request->shipment_ids ?? []);

        $deliverySheet = DeliverySheet::create($validated);

        // Attach shipments if provided
        if ($request->filled('shipment_ids')) {
            $shipments = [];
            foreach ($request->shipment_ids as $index => $shipmentId) {
                $shipments[$shipmentId] = [
                    'sequence' => $index + 1,
                    'delivery_status' => 'pending'
                ];
            }
            $deliverySheet->shipments()->attach($shipments);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'DeliverySheet',
            'model_id' => $deliverySheet->delivery_sheet_id,
            'description' => "Created delivery sheet: {$deliverySheet->sheet_number}",
        ]);

        return redirect()->route('delivery-sheets.index')->with('success', 'Delivery Sheet created successfully.');
    }

    public function show(DeliverySheet $deliverySheet)
    {
        $deliverySheet->load(['driver', 'vehicle', 'creator', 'shipments']);
        return view('delivery-sheets.show', compact('deliverySheet'));
    }

    public function edit(DeliverySheet $deliverySheet)
    {
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::where('status', 'available')->orWhere('status', 'in-use')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $shipments = Shipment::where('status', 'in-transit')
            ->orWhere('status', 'out-for-delivery')
            ->get();
        $deliverySheet->load('shipments');
        
        return view('delivery-sheets.edit', compact('deliverySheet', 'drivers', 'vehicles', 'cities', 'shipments'));
    }

    public function update(Request $request, DeliverySheet $deliverySheet)
    {
        $validated = $request->validate([
            'sheet_date' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'delivery_city' => 'required|string|max:100',
            'delivery_date' => 'required|date',
            'status' => 'required|in:prepared,out-for-delivery,completed,cancelled',
            'shipment_ids' => 'nullable|array',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
        ]);

        $validated['total_shipments'] = count($request->shipment_ids ?? []);
        $deliverySheet->update($validated);

        // Update shipments if provided
        if ($request->has('shipment_ids')) {
            $shipments = [];
            foreach ($request->shipment_ids as $index => $shipmentId) {
                $shipments[$shipmentId] = [
                    'sequence' => $index + 1,
                    'delivery_status' => 'pending'
                ];
            }
            $deliverySheet->shipments()->sync($shipments);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'DeliverySheet',
            'model_id' => $deliverySheet->delivery_sheet_id,
            'description' => "Updated delivery sheet: {$deliverySheet->sheet_number}",
        ]);

        return redirect()->route('delivery-sheets.index')->with('success', 'Delivery Sheet updated successfully.');
    }

    public function destroy(DeliverySheet $deliverySheet)
    {
        $sheetNumber = $deliverySheet->sheet_number;
        $deliverySheet->shipments()->detach();
        $deliverySheet->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'DeliverySheet',
            'model_id' => $deliverySheet->delivery_sheet_id,
            'description' => "Deleted delivery sheet: {$sheetNumber}",
        ]);

        return redirect()->route('delivery-sheets.index')->with('success', 'Delivery Sheet deleted successfully.');
    }
}
