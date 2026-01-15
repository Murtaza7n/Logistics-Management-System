<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('employee')->latest();

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('emp_id')) {
            $query->where('emp_id', $request->emp_id);
        }

        $payrolls = $query->paginate(15);
        $employees = Employee::where('status', 'active')->get();

        return view('payrolls.index', compact('payrolls', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
            'basic_salary' => 'required|numeric|min:0',
            'overtime' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'deduction_details' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Check if payroll already exists for this employee and month
        $exists = Payroll::where('emp_id', $validated['emp_id'])
            ->where('month', $validated['month'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Payroll already exists for this employee and month.'])->withInput();
        }

        // Calculate net salary
        $net_salary = $validated['basic_salary'] 
            + ($validated['overtime'] ?? 0) 
            + ($validated['bonus'] ?? 0) 
            - ($validated['deductions'] ?? 0);

        $validated['net_salary'] = $net_salary;

        $payroll = Payroll::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Payroll',
            'model_id' => $payroll->payroll_id,
            'description' => "Created payroll for employee ID: {$payroll->emp_id}",
        ]);

        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully.');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('employee');
        return view('payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
            'basic_salary' => 'required|numeric|min:0',
            'overtime' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'deduction_details' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Check if payroll already exists for this employee and month (excluding current)
        $exists = Payroll::where('emp_id', $validated['emp_id'])
            ->where('month', $validated['month'])
            ->where('payroll_id', '!=', $payroll->payroll_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Payroll already exists for this employee and month.'])->withInput();
        }

        // Calculate net salary
        $net_salary = $validated['basic_salary'] 
            + ($validated['overtime'] ?? 0) 
            + ($validated['bonus'] ?? 0) 
            - ($validated['deductions'] ?? 0);

        $validated['net_salary'] = $net_salary;

        $payroll->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Payroll',
            'model_id' => $payroll->payroll_id,
            'description' => "Updated payroll for employee ID: {$payroll->emp_id}",
        ]);

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Payroll',
            'model_id' => $payroll->payroll_id,
            'description' => "Deleted payroll ID: {$payroll->payroll_id}",
        ]);

        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully.');
    }

    public function generatePayslip(Payroll $payroll)
    {
        $payroll->load('employee');
        return view('payrolls.payslip', compact('payroll'));
    }
}


