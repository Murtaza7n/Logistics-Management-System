<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\City;
use App\Models\CnNumberSequence;
use App\Models\ActivityLog;
use App\Services\CNNumberValidationService;
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
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $cnBooks = \App\Models\CNBook::where('status', 'active')
            ->where('remaining_count', '>', 0)
            ->orderBy('book_number')
            ->get();

        return view('shipments.create', compact('customers', 'vendors', 'vehicles', 'drivers', 'cities', 'cnBooks'));
    }

    public function store(Request $request)
    {
        // Validate CN Book is selected
        $validated = $request->validate([
            'cn_book_id' => 'required|exists:cn_books,id',
        ], [
            'cn_book_id.required' => 'Please select a CN Book.',
            'cn_book_id.exists' => 'Selected CN Book does not exist.',
        ]);

        // Get CN Book
        $cnBook = \App\Models\CNBook::findOrFail($request->input('cn_book_id'));
        
        // Check if book has available numbers
        if ($cnBook->remaining_count <= 0) {
            return back()
                ->withInput()
                ->withErrors(['cn_book_id' => 'Selected CN Book has no available numbers. Please select another book.']);
        }

        // Get system year (default to current year or from session)
        $systemYear = $request->input('system_year', session('system_year', '2526'));
        
        // Auto-generate CN number if not provided or auto-generate flag is set
        $cnNumber = $request->input('shipment_number');
        $autoGenerate = $request->input('auto_generate_cn', '0') === '1';
        
        $cityCode = $cnBook->city_code;
        if (!$cityCode && $request->input('entry_city')) {
            $city = City::find($request->input('entry_city'));
            $cityCode = $city ? $city->code : null;
        }
        
        if (empty($cnNumber) || $autoGenerate) {
            // Get next available number from the selected CN Book
            $nextNumber = $cnBook->getNextAvailableNumber();
            
            if ($nextNumber === null) {
                return back()
                    ->withInput()
                    ->withErrors(['cn_book_id' => 'No available CN numbers in the selected book.']);
            }
            
            // Format the CN number
            $cnNumber = sprintf(
                '%s-%s-%06d',
                $cnBook->system_year ?? $systemYear,
                $cnBook->city_code ?? $cityCode ?? 'GEN',
                $nextNumber
            );
        } else {
            // Validate manually entered CN number is in the selected book's range
            $numericPart = (int) preg_replace('/\D/', '', $cnNumber);
            
            if ($numericPart < $cnBook->start_number || $numericPart > $cnBook->end_number) {
                return back()
                    ->withInput()
                    ->withErrors(['shipment_number' => "CN number must be in range {$cnBook->start_number} - {$cnBook->end_number} for the selected book."]);
            }
            
            if (!$cnBook->isNumberAvailable($numericPart)) {
                return back()
                    ->withInput()
                    ->withErrors(['shipment_number' => 'CN number not available / already issued']);
            }
        }

        // Validate CN number using CN Book system
        $validationService = new CNNumberValidationService();
        $validation = $validationService->validateCNNumber($cnNumber, $cityCode, $systemYear);
        
        if (!$validation['valid']) {
            return back()
                ->withInput()
                ->withErrors(['shipment_number' => $validation['message']]);
        }

        $validated = $request->validate([
            'shipment_number' => 'required|string|max:255|unique:shipments,shipment_number',
            'system_year' => 'nullable|string|max:10',
            'entry_city' => 'nullable|exists:cities,city_id',
            'cn_type' => 'nullable|string|max:255',
            'shipper_code' => 'nullable|string|max:255',
            'shipper_name' => 'required|string|max:255',
            'shipper_address_line1' => 'nullable|string',
            'shipper_address_line2' => 'nullable|string',
            'shipper_address_line3' => 'nullable|string',
            'shipper_contact' => 'nullable|string|max:255',
            'consignee_code' => 'nullable|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'consignee_address_line1' => 'nullable|string',
            'consignee_address_line2' => 'nullable|string',
            'consignee_address_line3' => 'nullable|string',
            'consignee_contact' => 'nullable|string|max:255',
            'customer_id' => 'nullable|exists:customers,customer_id',
            'vendor_id' => 'nullable|exists:vendors,vendor_id',
            'sender' => 'nullable|string',
            'receiver' => 'nullable|string',
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
            'packages' => 'nullable|numeric|min:0',
            'packaging_type' => 'nullable|string|max:255',
            'freight_charges' => 'nullable|numeric|min:0',
            'labor_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'declared_value' => 'nullable|numeric|min:0',
            'payment_mode' => 'nullable|string|max:255',
            'delivery_type' => 'nullable|string|max:255',
            'status' => 'required|in:booked,picked-up,in-transit,out-for-delivery,delivered,cancelled',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'pickup_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        // Merge auto-generated CN number and system year
        $validated['shipment_number'] = $cnNumber;
        $validated['system_year'] = $systemYear;
        $validated['cn_book_id'] = $cnBook->id;

        // Use database transaction to ensure atomicity
        return \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $cnNumber, $validationService, $cityCode, $systemYear) {
            $shipment = Shipment::create($validated);

            // Issue CN number and create usage record
            $issueResult = $validationService->issueCNNumber(
                $cnNumber,
                $shipment->shipment_id,
                auth()->id(),
                $cityCode,
                $systemYear
            );

            if (!$issueResult['success']) {
                // Rollback will happen automatically
                return back()
                    ->withInput()
                    ->withErrors(['shipment_number' => $issueResult['message']]);
            }

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
                'description' => "Created shipment: {$shipment->shipment_number} using CN Book: " . ($issueResult['usage']->cnBook->book_number ?? 'N/A'),
            ]);

            return redirect()->route('shipments.index')->with('success', 'Shipment created successfully with CN: ' . $cnNumber);
        });
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
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('shipments.edit', compact('shipment', 'customers', 'vendors', 'vehicles', 'drivers', 'cities'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'shipment_number' => 'required|string|max:255|unique:shipments,shipment_number,' . $shipment->shipment_id . ',shipment_id',
            'entry_city' => 'nullable|exists:cities,city_id',
            'cn_type' => 'nullable|string|max:255',
            'shipper_code' => 'nullable|string|max:255',
            'shipper_name' => 'required|string|max:255',
            'shipper_address_line1' => 'nullable|string',
            'shipper_address_line2' => 'nullable|string',
            'shipper_address_line3' => 'nullable|string',
            'shipper_contact' => 'nullable|string|max:255',
            'consignee_code' => 'nullable|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'consignee_address_line1' => 'nullable|string',
            'consignee_address_line2' => 'nullable|string',
            'consignee_address_line3' => 'nullable|string',
            'consignee_contact' => 'nullable|string|max:255',
            'customer_id' => 'nullable|exists:customers,customer_id',
            'vendor_id' => 'nullable|exists:vendors,vendor_id',
            'sender' => 'nullable|string',
            'receiver' => 'nullable|string',
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
            'packages' => 'nullable|numeric|min:0',
            'packaging_type' => 'nullable|string|max:255',
            'freight_charges' => 'nullable|numeric|min:0',
            'labor_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'declared_value' => 'nullable|numeric|min:0',
            'payment_mode' => 'nullable|string|max:255',
            'delivery_type' => 'nullable|string|max:255',
            'status' => 'required|in:booked,picked-up,in-transit,out-for-delivery,delivered,cancelled',
            'vehicle_id' => 'nullable|exists:vehicles,vehicle_id',
            'driver_id' => 'nullable|exists:drivers,driver_id',
            'pickup_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'actual_delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
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

    public function detailSearch(Request $request)
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $statuses = ['booked', 'picked-up', 'in-transit', 'out-for-delivery', 'delivered', 'cancelled'];

        $shipments = collect();

        if ($request->hasAny(['cn_number', 'shipper_name', 'consignee_name', 'status', 'city', 'vehicle_id', 'driver_id', 'date_from', 'date_to'])) {
            $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver', 'entryCity']);

            if ($request->filled('cn_number')) {
                $query->where('shipment_number', 'like', '%' . $request->cn_number . '%');
            }

            if ($request->filled('shipper_name')) {
                $query->where('shipper_name', 'like', '%' . $request->shipper_name . '%');
            }

            if ($request->filled('consignee_name')) {
                $query->where('consignee_name', 'like', '%' . $request->consignee_name . '%');
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('city')) {
                $query->where('entry_city', $request->city);
            }

            if ($request->filled('vehicle_id')) {
                $query->where('vehicle_id', $request->vehicle_id);
            }

            if ($request->filled('driver_id')) {
                $query->where('driver_id', $request->driver_id);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $shipments = $query->latest()->paginate(20)->appends($request->all());
        }

        return view('shipments.detail-search', compact('shipments', 'customers', 'vendors', 'vehicles', 'drivers', 'cities', 'statuses'));
    }

    public function searchResults(Request $request)
    {
        return $this->detailSearch($request);
    }
}


