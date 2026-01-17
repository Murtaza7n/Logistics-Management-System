<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Loan;
use App\Models\MonthlyDeductionAllowance;
use App\Models\AuthorizedLeave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollModuleController extends Controller
{
    // ============ DEPARTMENT CODES ============
    public function departments()
    {
        $departments = Department::orderBy('code')->get();
        return view('payroll.departments', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:departments,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Department::create($validated);
        return redirect()->route('payroll.departments')->with('success', 'Department created successfully.');
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:departments,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department->update($validated);
        return redirect()->route('payroll.departments')->with('success', 'Department updated successfully.');
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('payroll.departments')->with('success', 'Department deleted successfully.');
    }

    // ============ DESIGNATION CODES ============
    public function designations()
    {
        $designations = Designation::orderBy('code')->get();
        return view('payroll.designations', compact('designations'));
    }

    public function storeDesignation(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:designations,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Designation::create($validated);
        return redirect()->route('payroll.designations')->with('success', 'Designation created successfully.');
    }

    public function updateDesignation(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:designations,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $designation->update($validated);
        return redirect()->route('payroll.designations')->with('success', 'Designation updated successfully.');
    }

    public function deleteDesignation($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
        return redirect()->route('payroll.designations')->with('success', 'Designation deleted successfully.');
    }

    // ============ EMPLOYEE MASTER FILE ============
    public function employeeMaster()
    {
        $employees = Employee::with(['payrolls'])->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        return view('payroll.employee-master', compact('employees', 'departments', 'designations'));
    }

    // ============ LOAN MASTER FILE ============
    public function loans()
    {
        $loans = Loan::with('employee')->orderBy('created_at', 'desc')->get();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('payroll.loans', compact('loans', 'employees'));
    }

    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,emp_id',
            'loan_type' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'installment_amount' => 'required|numeric|min:0',
            'total_installments' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        Loan::create($validated);
        return redirect()->route('payroll.loans')->with('success', 'Loan created successfully.');
    }

    public function updateLoan(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,emp_id',
            'loan_type' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'installment_amount' => 'required|numeric|min:0',
            'total_installments' => 'required|integer|min:1',
            'paid_installments' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $loan->update($validated);
        return redirect()->route('payroll.loans')->with('success', 'Loan updated successfully.');
    }

    public function deleteLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return redirect()->route('payroll.loans')->with('success', 'Loan deleted successfully.');
    }

    // ============ MONTHLY DEDUCTION/ALLOWANCES ============
    public function deductionsAllowances()
    {
        $deductionsAllowances = MonthlyDeductionAllowance::with('employee')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('payroll.deductions-allowances', compact('deductionsAllowances', 'employees'));
    }

    public function storeDeductionAllowance(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,emp_id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:3000',
            'deduction_type' => 'nullable|string|max:255',
            'allowance_type' => 'nullable|string|max:255',
            'deduction_amount' => 'nullable|numeric|min:0',
            'allowance_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        MonthlyDeductionAllowance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            $validated
        );

        return redirect()->route('payroll.deductions-allowances')->with('success', 'Deduction/Allowance saved successfully.');
    }

    // ============ AUTHORIZED LEAVES ============
    public function authorizedLeaves()
    {
        $authorizedLeaves = AuthorizedLeave::with('employee')
            ->orderBy('year', 'desc')
            ->orderBy('leave_type')
            ->get();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('payroll.authorized-leaves', compact('authorizedLeaves', 'employees'));
    }

    public function storeAuthorizedLeave(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,emp_id',
            'leave_type' => 'required|string|max:255',
            'total_leaves' => 'required|integer|min:0',
            'used_leaves' => 'nullable|integer|min:0',
            'year' => 'required|integer|min:2000|max:3000',
            'notes' => 'nullable|string',
        ]);

        $validated['remaining_leaves'] = $validated['total_leaves'] - ($validated['used_leaves'] ?? 0);

        AuthorizedLeave::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'leave_type' => $validated['leave_type'],
                'year' => $validated['year'],
            ],
            $validated
        );

        return redirect()->route('payroll.authorized-leaves')->with('success', 'Authorized leave saved successfully.');
    }

    // ============ MONTHLY PAYROLL PROCESSING ============
    public function monthlyPayrollProcessing()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('payroll.monthly-payroll-processing', compact('employees', 'departments'));
    }

    public function processPayroll(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:3000',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:employees,emp_id',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // This is a placeholder - implement actual payroll calculation logic
        return redirect()->route('payroll.monthly-payroll-processing')
            ->with('success', 'Payroll processing initiated. This feature will calculate salaries, deductions, and allowances.');
    }
}

