@extends('layouts.app')

@section('title', 'Loan Master File')
@section('page-title', 'Loan Master File')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Loan Master File
    </h1>
    <p class="page-subtitle">Manage employee loans and advances</p>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Loans</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLoanModal">
                 Add Loan
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Loan Type</th>
                        <th>Loan Amount</th>
                        <th>Installment</th>
                        <th>Paid/Total</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr>
                        <td><strong>{{ $loan->employee->name ?? 'N/A' }}</strong></td>
                        <td>{{ $loan->loan_type }}</td>
                        <td>Rs.{{ number_format($loan->loan_amount, 2) }}</td>
                        <td>Rs.{{ number_format($loan->installment_amount, 2) }}</td>
                        <td>{{ $loan->paid_installments }}/{{ $loan->total_installments }}</td>
                        <td>
                            <span class="badge badge-{{ $loan->status === 'active' ? 'primary' : ($loan->status === 'completed' ? 'secondary' : 'dark') }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td>{{ $loan->start_date->format('Y-m-d') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editLoan({{ $loan->id }})">
                                
                            </button>
                            <form action="{{ route('payroll.loans.delete', $loan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No loans found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Loan Modal -->
<div class="modal fade" id="addLoanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="loanForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee <span class="text-danger">*</span></label>
                            <select class="form-select" name="employee_id" id="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->emp_id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loan Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="loan_type" id="loan_type" required>
                                <option value="Personal">Personal</option>
                                <option value="Advance">Advance</option>
                                <option value="Emergency">Emergency</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loan Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="loan_amount" id="loan_amount" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Interest Rate (%)</label>
                            <input type="number" step="0.01" class="form-control" name="interest_rate" id="interest_rate" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Installment Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="installment_amount" id="installment_amount" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Installments <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="total_installments" id="total_installments" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" id="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editLoan(id) {
    // Load loan data via AJAX or pass data from server
    // For now, just show the modal - implement AJAX call to load data
    document.getElementById('modalTitle').textContent = 'Edit Loan';
    document.getElementById('loanForm').action = '{{ url('payroll/loans') }}/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    new bootstrap.Modal(document.getElementById('addLoanModal')).show();
}

document.getElementById('addLoanModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('modalTitle').textContent = 'Add Loan';
    document.getElementById('loanForm').action = '{{ route('payroll.loans.store') }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('loanForm').reset();
});
</script>
@endsection

