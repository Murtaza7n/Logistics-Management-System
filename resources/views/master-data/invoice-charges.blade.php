@extends('layouts.app')

@section('title', 'Invoice Charges')
@section('page-title', 'Invoice Charges Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Invoice Charges</h1>
            <p class="page-subtitle">Manage invoice charges and rates</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInvoiceChargeModal">
                Add Invoice Charge
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="charge_type">
                    <option value="">All Types</option>
                    <option value="freight" {{ request('charge_type') === 'freight' ? 'selected' : '' }}>Freight</option>
                    <option value="labor" {{ request('charge_type') === 'labor' ? 'selected' : '' }}>Labor</option>
                    <option value="fuel" {{ request('charge_type') === 'fuel' ? 'selected' : '' }}>Fuel</option>
                    <option value="other" {{ request('charge_type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('master-data.invoice-charges') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Charge Code</th>
                        <th>Charge Name</th>
                        <th>Type</th>
                        <th>Calculation</th>
                        <th>Rate</th>
                        <th>Taxable</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoiceCharges as $charge)
                    <tr>
                        <td><strong>{{ $charge->charge_code }}</strong></td>
                        <td>{{ $charge->charge_name }}</td>
                        <td><span class="badge bg-info">{{ $charge->charge_type ?? '-' }}</span></td>
                        <td>{{ ucfirst(str_replace('_', ' ', $charge->calculation_type)) }}</td>
                        <td>{{ number_format($charge->rate, 2) }}</td>
                        <td>
                            @if($charge->is_taxable)
                                <span class="badge bg-warning">Yes ({{ $charge->tax_rate }}%)</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $charge->is_active ? 'success' : 'secondary' }}">
                                {{ $charge->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editInvoiceCharge({{ $charge->id }})">Edit</button>
                            <form action="{{ route('master-data.invoice-charges.delete', $charge->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No invoice charges found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $invoiceCharges->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addInvoiceChargeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="invoiceChargeForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Invoice Charge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Charge Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="charge_code" id="charge_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Charge Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="charge_name" id="charge_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Charge Type</label>
                            <select class="form-select" name="charge_type" id="charge_type">
                                <option value="">Select Type</option>
                                <option value="freight">Freight</option>
                                <option value="labor">Labor</option>
                                <option value="fuel">Fuel</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Calculation Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="calculation_type" id="calculation_type" required>
                                <option value="fixed">Fixed</option>
                                <option value="per_kg">Per KG</option>
                                <option value="per_piece">Per Piece</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rate <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="rate" id="rate" required value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" step="0.01" class="form-control" name="tax_rate" id="tax_rate" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_taxable" id="is_taxable" value="1">
                            <label class="form-check-label" for="is_taxable">Is Taxable</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
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
let invoiceChargesData = @json($invoiceCharges->items());

function editInvoiceCharge(id) {
    const charge = invoiceChargesData.find(c => c.id === id);
    if (!charge) return;

    document.getElementById('modalTitle').textContent = 'Edit Invoice Charge';
    document.getElementById('invoiceChargeForm').action = '{{ route("master-data.invoice-charges.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('charge_code').value = charge.charge_code;
    document.getElementById('charge_name').value = charge.charge_name;
    document.getElementById('charge_type').value = charge.charge_type || '';
    document.getElementById('calculation_type').value = charge.calculation_type;
    document.getElementById('rate').value = charge.rate;
    document.getElementById('tax_rate').value = charge.tax_rate || 0;
    document.getElementById('is_taxable').checked = charge.is_taxable;
    document.getElementById('description').value = charge.description || '';
    document.getElementById('is_active').checked = charge.is_active;

    new bootstrap.Modal(document.getElementById('addInvoiceChargeModal')).show();
}

document.getElementById('addInvoiceChargeModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('invoiceChargeForm').reset();
    document.getElementById('invoiceChargeForm').action = '{{ route("master-data.invoice-charges.store") }}';
    document.getElementById('modalTitle').textContent = 'Add Invoice Charge';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
@endsection

