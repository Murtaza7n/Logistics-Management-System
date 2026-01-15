<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(15);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff,driver,manager',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $employee = Employee::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Employee',
            'model_id' => $employee->emp_id,
            'description' => "Created employee: {$employee->name}",
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load('payrolls');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff,driver,manager',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $employee->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Employee',
            'model_id' => $employee->emp_id,
            'description' => "Updated employee: {$employee->name}",
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $name = $employee->name;
        $employee->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Employee',
            'model_id' => $employee->emp_id,
            'description' => "Deleted employee: {$name}",
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}


