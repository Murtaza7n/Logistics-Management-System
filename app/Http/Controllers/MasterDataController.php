<?php

namespace App\Http\Controllers;

use App\Models\ItemCode;
use App\Models\ContainerSize;
use App\Models\InvoiceCharge;
use App\Models\CargoOfficer;
use App\Models\ZoneCode;
use App\Models\PartyAreaRate;
use App\Models\City;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    // ============ ITEM CODES ============
    public function itemCodes(Request $request)
    {
        $query = ItemCode::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('item_code', 'like', "%{$search}%")
                  ->orWhere('item_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $itemCodes = $query->orderBy('item_code')->paginate(20);
        return view('master-data.item-codes', compact('itemCodes'));
    }

    public function storeItemCode(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|string|max:50|unique:item_codes,item_code',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'unit_price' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        ItemCode::create($validated);
        return redirect()->route('master-data.item-codes')->with('success', 'Item code created successfully.');
    }

    public function updateItemCode(Request $request, $id)
    {
        $itemCode = ItemCode::findOrFail($id);
        $validated = $request->validate([
            'item_code' => 'required|string|max:50|unique:item_codes,item_code,' . $id,
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'unit_price' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $itemCode->update($validated);
        return redirect()->route('master-data.item-codes')->with('success', 'Item code updated successfully.');
    }

    public function deleteItemCode($id)
    {
        $itemCode = ItemCode::findOrFail($id);
        $itemCode->delete();
        return redirect()->route('master-data.item-codes')->with('success', 'Item code deleted successfully.');
    }

    // ============ CONTAINER SIZES ============
    public function containerSizes(Request $request)
    {
        $query = ContainerSize::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('size_code', 'like', "%{$search}%")
                  ->orWhere('size_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $containerSizes = $query->orderBy('size_code')->paginate(20);
        return view('master-data.container-sizes', compact('containerSizes'));
    }

    public function storeContainerSize(Request $request)
    {
        $validated = $request->validate([
            'size_code' => 'required|string|max:50|unique:container_sizes,size_code',
            'size_name' => 'required|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0',
            'max_volume' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        ContainerSize::create($validated);
        return redirect()->route('master-data.container-sizes')->with('success', 'Container size created successfully.');
    }

    public function updateContainerSize(Request $request, $id)
    {
        $containerSize = ContainerSize::findOrFail($id);
        $validated = $request->validate([
            'size_code' => 'required|string|max:50|unique:container_sizes,size_code,' . $id,
            'size_name' => 'required|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0',
            'max_volume' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $containerSize->update($validated);
        return redirect()->route('master-data.container-sizes')->with('success', 'Container size updated successfully.');
    }

    public function deleteContainerSize($id)
    {
        $containerSize = ContainerSize::findOrFail($id);
        $containerSize->delete();
        return redirect()->route('master-data.container-sizes')->with('success', 'Container size deleted successfully.');
    }

    // ============ INVOICE CHARGES ============
    public function invoiceCharges(Request $request)
    {
        $query = InvoiceCharge::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('charge_code', 'like', "%{$search}%")
                  ->orWhere('charge_name', 'like', "%{$search}%")
                  ->orWhere('charge_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('charge_type')) {
            $query->where('charge_type', $request->charge_type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $invoiceCharges = $query->orderBy('charge_code')->paginate(20);
        return view('master-data.invoice-charges', compact('invoiceCharges'));
    }

    public function storeInvoiceCharge(Request $request)
    {
        $validated = $request->validate([
            'charge_code' => 'required|string|max:50|unique:invoice_charges,charge_code',
            'charge_name' => 'required|string|max:255',
            'charge_type' => 'nullable|string|max:100',
            'calculation_type' => 'required|in:fixed,per_kg,per_piece,percentage',
            'rate' => 'required|numeric|min:0',
            'is_taxable' => 'boolean',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        InvoiceCharge::create($validated);
        return redirect()->route('master-data.invoice-charges')->with('success', 'Invoice charge created successfully.');
    }

    public function updateInvoiceCharge(Request $request, $id)
    {
        $invoiceCharge = InvoiceCharge::findOrFail($id);
        $validated = $request->validate([
            'charge_code' => 'required|string|max:50|unique:invoice_charges,charge_code,' . $id,
            'charge_name' => 'required|string|max:255',
            'charge_type' => 'nullable|string|max:100',
            'calculation_type' => 'required|in:fixed,per_kg,per_piece,percentage',
            'rate' => 'required|numeric|min:0',
            'is_taxable' => 'boolean',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $invoiceCharge->update($validated);
        return redirect()->route('master-data.invoice-charges')->with('success', 'Invoice charge updated successfully.');
    }

    public function deleteInvoiceCharge($id)
    {
        $invoiceCharge = InvoiceCharge::findOrFail($id);
        $invoiceCharge->delete();
        return redirect()->route('master-data.invoice-charges')->with('success', 'Invoice charge deleted successfully.');
    }

    // ============ CARGO OFFICERS ============
    public function cargoOfficers(Request $request)
    {
        $query = CargoOfficer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('officer_code', 'like', "%{$search}%")
                  ->orWhere('officer_name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $cargoOfficers = $query->orderBy('officer_code')->paginate(20);
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('master-data.cargo-officers', compact('cargoOfficers', 'cities'));
    }

    public function storeCargoOfficer(Request $request)
    {
        $validated = $request->validate([
            'officer_code' => 'required|string|max:50|unique:cargo_officers,officer_code',
            'officer_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'hub' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        CargoOfficer::create($validated);
        return redirect()->route('master-data.cargo-officers')->with('success', 'Cargo officer created successfully.');
    }

    public function updateCargoOfficer(Request $request, $id)
    {
        $cargoOfficer = CargoOfficer::findOrFail($id);
        $validated = $request->validate([
            'officer_code' => 'required|string|max:50|unique:cargo_officers,officer_code,' . $id,
            'officer_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'hub' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $cargoOfficer->update($validated);
        return redirect()->route('master-data.cargo-officers')->with('success', 'Cargo officer updated successfully.');
    }

    public function deleteCargoOfficer($id)
    {
        $cargoOfficer = CargoOfficer::findOrFail($id);
        $cargoOfficer->delete();
        return redirect()->route('master-data.cargo-officers')->with('success', 'Cargo officer deleted successfully.');
    }

    // ============ CARGO OFFICER-WISE CN STOCK ISSUE ============
    public function cargoOfficerStockIssue(Request $request)
    {
        // This will show CN books issued to cargo officers
        $query = DB::table('cn_books')
            ->leftJoin('cargo_officers', 'cn_books.issued_to_officer', '=', 'cargo_officers.id')
            ->select('cn_books.*', 'cargo_officers.officer_name', 'cargo_officers.officer_code');

        if ($request->filled('officer_id')) {
            $query->where('cn_books.issued_to_officer', $request->officer_id);
        }

        $stockIssues = $query->orderBy('cn_books.created_at', 'desc')->paginate(20);
        $cargoOfficers = CargoOfficer::where('is_active', true)->orderBy('officer_name')->get();
        
        return view('master-data.cargo-officer-stock-issue', compact('stockIssues', 'cargoOfficers'));
    }

    // ============ ZONE CODES ============
    public function zoneCodes(Request $request)
    {
        $query = ZoneCode::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('zone_code', 'like', "%{$search}%")
                  ->orWhere('zone_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $zoneCodes = $query->orderBy('zone_code')->paginate(20);
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('master-data.zone-codes', compact('zoneCodes', 'cities'));
    }

    public function storeZoneCode(Request $request)
    {
        $validated = $request->validate([
            'zone_code' => 'required|string|max:50|unique:zone_codes,zone_code',
            'zone_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        ZoneCode::create($validated);
        return redirect()->route('master-data.zone-codes')->with('success', 'Zone code created successfully.');
    }

    public function updateZoneCode(Request $request, $id)
    {
        $zoneCode = ZoneCode::findOrFail($id);
        $validated = $request->validate([
            'zone_code' => 'required|string|max:50|unique:zone_codes,zone_code,' . $id,
            'zone_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $zoneCode->update($validated);
        return redirect()->route('master-data.zone-codes')->with('success', 'Zone code updated successfully.');
    }

    public function deleteZoneCode($id)
    {
        $zoneCode = ZoneCode::findOrFail($id);
        $zoneCode->delete();
        return redirect()->route('master-data.zone-codes')->with('success', 'Zone code deleted successfully.');
    }

    // ============ PARTY OR AREA-WISE RATE ============
    public function partyAreaRates(Request $request)
    {
        $query = PartyAreaRate::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('party_name', 'like', "%{$search}%")
                  ->orWhere('party_code', 'like', "%{$search}%")
                  ->orWhere('area_name', 'like', "%{$search}%");
            });
        }

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
            $query->where('is_active', $request->status === 'active');
        }

        $partyAreaRates = $query->orderBy('party_name')->paginate(20);
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        
        return view('master-data.party-area-rates', compact('partyAreaRates', 'cities', 'customers', 'vendors'));
    }

    public function storePartyAreaRate(Request $request)
    {
        $validated = $request->validate([
            'party_type' => 'nullable|in:Customer,Vendor,Area',
            'party_code' => 'nullable|string|max:50',
            'party_name' => 'required|string|max:255',
            'from_city' => 'nullable|string|max:100',
            'to_city' => 'nullable|string|max:100',
            'from_zone' => 'nullable|string|max:100',
            'to_zone' => 'nullable|string|max:100',
            'area_name' => 'nullable|string|max:255',
            'rate_per_kg' => 'nullable|numeric|min:0',
            'rate_per_piece' => 'nullable|numeric|min:0',
            'minimum_charge' => 'nullable|numeric|min:0',
            'vehicle_type' => 'nullable|string|max:50',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        PartyAreaRate::create($validated);
        return redirect()->route('master-data.party-area-rates')->with('success', 'Party/Area rate created successfully.');
    }

    public function updatePartyAreaRate(Request $request, $id)
    {
        $partyAreaRate = PartyAreaRate::findOrFail($id);
        $validated = $request->validate([
            'party_type' => 'nullable|in:Customer,Vendor,Area',
            'party_code' => 'nullable|string|max:50',
            'party_name' => 'required|string|max:255',
            'from_city' => 'nullable|string|max:100',
            'to_city' => 'nullable|string|max:100',
            'from_zone' => 'nullable|string|max:100',
            'to_zone' => 'nullable|string|max:100',
            'area_name' => 'nullable|string|max:255',
            'rate_per_kg' => 'nullable|numeric|min:0',
            'rate_per_piece' => 'nullable|numeric|min:0',
            'minimum_charge' => 'nullable|numeric|min:0',
            'vehicle_type' => 'nullable|string|max:50',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $partyAreaRate->update($validated);
        return redirect()->route('master-data.party-area-rates')->with('success', 'Party/Area rate updated successfully.');
    }

    public function deletePartyAreaRate($id)
    {
        $partyAreaRate = PartyAreaRate::findOrFail($id);
        $partyAreaRate->delete();
        return redirect()->route('master-data.party-area-rates')->with('success', 'Party/Area rate deleted successfully.');
    }
}
