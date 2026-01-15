<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(15);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $customer = Customer::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Customer',
            'model_id' => $customer->customer_id,
            'description' => "Created customer: {$customer->name}",
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['shipments', 'invoices']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $customer->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Customer',
            'model_id' => $customer->customer_id,
            'description' => "Updated customer: {$customer->name}",
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Customer',
            'model_id' => $customer->customer_id,
            'description' => "Deleted customer: {$name}",
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}


