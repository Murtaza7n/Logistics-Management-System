<?php

namespace App\Http\Controllers;

use App\Models\CnExpenseSheet;
use App\Models\CnDeliveryReference;
use App\Models\PartyFuelRate;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\City;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogisticsController extends Controller
{
    public function initialSetup()
    {
        return view('logistics.initial-setup');
    }

    public function otherCnExpenseSheet(Request $request)
    {
        $query = CnExpenseSheet::with(['shipment', 'creator'])->latest();

        if ($request->filled('shipment_id')) {
            $query->where('shipment_id', $request->shipment_id);
        }

        if ($request->filled('expense_type')) {
            $query->where('expense_type', $request->expense_type);
        }

        $expenseSheets = $query->paginate(15);
        $shipments = Shipment::latest()->get();

        return view('logistics.other-cn-expense-sheet', compact('expenseSheets', 'shipments'));
    }

    public function storeExpenseSheet(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,shipment_id',
            'expense_type' => 'required|string|max:50',
            'expense_category' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:0',
            'vendor_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'payment_mode' => 'nullable|string|max:50',
            'expense_date' => 'required|date',
        ]);

        $systemYear = session('system_year', '2526');
        $sheetNumber = 'EXP-' . $systemYear . '-' . strtoupper(Str::random(6));
        
        while (CnExpenseSheet::where('sheet_number', $sheetNumber)->exists()) {
            $sheetNumber = 'EXP-' . $systemYear . '-' . strtoupper(Str::random(6));
        }

        $validated['sheet_number'] = $sheetNumber;
        $validated['system_year'] = $systemYear;
        $validated['created_by'] = auth()->id();

        $expenseSheet = CnExpenseSheet::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'CnExpenseSheet',
            'model_id' => $expenseSheet->expense_sheet_id,
            'description' => "Created expense sheet: {$expenseSheet->sheet_number}",
        ]);

        return redirect()->route('logistics.other-cn-expense-sheet')->with('success', 'Expense sheet created successfully.');
    }

    public function cnDeliveryReferenceNo(Request $request)
    {
        $query = CnDeliveryReference::with(['shipment', 'creator'])->latest();

        if ($request->filled('shipment_id')) {
            $query->where('shipment_id', $request->shipment_id);
        }

        if ($request->filled('reference_number')) {
            $query->where('reference_number', 'like', '%' . $request->reference_number . '%');
        }

        $references = $query->paginate(15);
        $shipments = Shipment::where('status', 'delivered')->orWhere('status', 'out-for-delivery')->get();

        return view('logistics.cn-delivery-reference-no', compact('references', 'shipments'));
    }

    public function storeDeliveryReference(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,shipment_id',
            'reference_number' => 'required|string|max:100|unique:cn_delivery_references,reference_number',
            'reference_type' => 'nullable|string|max:50',
            'reference_date' => 'nullable|date',
            'delivered_by' => 'nullable|string|max:255',
            'received_by' => 'nullable|string|max:255',
            'delivery_address' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        $reference = CnDeliveryReference::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'CnDeliveryReference',
            'model_id' => $reference->reference_id,
            'description' => "Created delivery reference: {$reference->reference_number}",
        ]);

        return redirect()->route('logistics.cn-delivery-reference-no')->with('success', 'Delivery reference created successfully.');
    }

    public function partyFuelRates(Request $request)
    {
        $query = PartyFuelRate::with('creator')->latest();

        if ($request->filled('party_type')) {
            $query->where('party_type', $request->party_type);
        }

        if ($request->filled('from_city')) {
            $query->where('from_city', $request->from_city);
        }

        if ($request->filled('to_city')) {
            $query->where('to_city', $request->to_city);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fuelRates = $query->paginate(15);
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();

        return view('logistics.party-fuel-rates', compact('fuelRates', 'cities', 'customers', 'vendors'));
    }

    public function storeFuelRate(Request $request)
    {
        $validated = $request->validate([
            'party_type' => 'required|in:Customer,Vendor,Driver,Other',
            'party_id' => 'nullable|integer',
            'party_code' => 'nullable|string|max:50',
            'party_name' => 'required|string|max:255',
            'from_city' => 'required|string|max:100',
            'to_city' => 'required|string|max:100',
            'fuel_rate' => 'required|numeric|min:0',
            'vehicle_type' => 'nullable|string|max:50',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['created_by'] = auth()->id();

        $fuelRate = PartyFuelRate::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'PartyFuelRate',
            'model_id' => $fuelRate->fuel_rate_id,
            'description' => "Created fuel rate for: {$fuelRate->party_name}",
        ]);

        return redirect()->route('logistics.party-fuel-rates')->with('success', 'Fuel rate created successfully.');
    }
}
