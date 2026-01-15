<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(15);
        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'services' => 'nullable|string',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'billing_terms' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $vendor = Vendor::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Vendor',
            'model_id' => $vendor->vendor_id,
            'description' => "Created vendor: {$vendor->name}",
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['shipments', 'invoices']);
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'services' => 'nullable|string',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'billing_terms' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $vendor->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Vendor',
            'model_id' => $vendor->vendor_id,
            'description' => "Updated vendor: {$vendor->name}",
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $name = $vendor->name;
        $vendor->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Vendor',
            'model_id' => $vendor->vendor_id,
            'description' => "Deleted vendor: {$name}",
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}


