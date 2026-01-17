@extends('layouts.app')

@section('title', 'Designation Codes')
@section('page-title', 'Designation Codes')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        Designation Codes
    </h1>
    <p class="page-subtitle">Manage designation codes and information</p>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">Designations</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                Add Designation
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Employees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designations as $designation)
                    <tr>
                        <td><strong>{{ $designation->code }}</strong></td>
                        <td>{{ $designation->name }}</td>
                        <td>{{ $designation->description ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $designation->is_active ? 'primary' : 'secondary' }}">
                                {{ $designation->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $designation->employees()->count() }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary" 
                                        onclick="editDesignation({{ $designation->id }}, '{{ $designation->code }}', '{{ $designation->name }}', '{{ addslashes($designation->description ?? '') }}', {{ $designation->is_active ? 'true' : 'false' }})"
                                        title="Edit Designation">
                                    Edit
                                </button>
                                <form action="{{ route('payroll.designations.delete', $designation->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this designation? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Designation">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No designations found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Designation Modal -->
<div class="modal fade" id="addDesignationModal" tabindex="-1" aria-labelledby="addDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--orange-gradient-start) 0%, var(--orange-gradient-end) 100%); color: var(--clean-white); border-bottom: none;">
                <div>
                    <h5 class="modal-title mb-1" id="modalTitle" style="font-weight: 600; font-size: 1.25rem;">Add Designation</h5>
                    <small class="text-white-50" style="font-size: 0.85rem;">Create a new designation code and information</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="designationForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label fw-semibold">
                                Designation Code <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--bg-tertiary); border-right: none;">
                                    <span style="color: var(--orange-primary); font-weight: 600;">#</span>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       name="code" 
                                       id="code" 
                                       placeholder="e.g., MGR, DEV, ACC"
                                       required
                                       style="border-left: none;"
                                       maxlength="50">
                            </div>
                            <small class="form-text text-muted">Unique code identifier for the designation</small>
                            <div class="invalid-feedback" id="code-error"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                Designation Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="name" 
                                   id="name" 
                                   placeholder="e.g., Manager, Developer, Accountant"
                                   required
                                   maxlength="255">
                            <small class="form-text text-muted">Full name of the designation</small>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea class="form-control" 
                                      name="description" 
                                      id="description" 
                                      rows="4"
                                      placeholder="Enter a brief description of the designation's responsibilities and requirements..."
                                      style="resize: vertical;"></textarea>
                            <small class="form-text text-muted">Optional: Provide additional details about this designation</small>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check form-switch" style="padding-left: 3rem;">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1" 
                                       checked
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label fw-semibold" for="is_active" style="cursor: pointer; padding-top: 0.25rem;">
                                    Active Designation
                                </label>
                            </div>
                            <small class="form-text text-muted d-block ms-5">Inactive designations will not appear in employee assignment options</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 1.25rem 2rem; background-color: var(--bg-secondary);">
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            data-bs-dismiss="modal"
                            style="min-width: 100px;">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="btn btn-primary"
                            style="min-width: 100px; background-color: var(--metallic-silver); border-color: var(--metallic-silver); color: var(--black); font-weight: 500;">
                        Save Designation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editDesignation(id, code, name, description, isActive) {
    const modal = document.getElementById('addDesignationModal');
    const modalTitle = modal.querySelector('#modalTitle');
    const modalSubtitle = modalTitle.nextElementSibling;
    const form = document.getElementById('designationForm');
    
    modalTitle.textContent = 'Edit Designation';
    if (modalSubtitle) {
        modalSubtitle.textContent = 'Update designation information and settings';
    }
    
    form.action = '{{ url('payroll/designations') }}/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('code').value = code || '';
    document.getElementById('name').value = name || '';
    document.getElementById('description').value = description || '';
    document.getElementById('is_active').checked = isActive;
    
    // Clear any previous validation errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    new bootstrap.Modal(modal).show();
}

document.getElementById('addDesignationModal').addEventListener('hidden.bs.modal', function() {
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = modalTitle.nextElementSibling;
    const form = document.getElementById('designationForm');
    
    modalTitle.textContent = 'Add Designation';
    if (modalSubtitle) {
        modalSubtitle.textContent = 'Create a new designation code and information';
    }
    
    form.action = '{{ route('payroll.designations.store') }}';
    document.getElementById('methodField').innerHTML = '';
    form.reset();
    
    // Clear validation errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
});

// Form validation
document.getElementById('designationForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    // Validate Code
    const code = document.getElementById('code');
    if (!code.value.trim()) {
        code.classList.add('is-invalid');
        document.getElementById('code-error').textContent = 'Designation code is required.';
        isValid = false;
    } else if (code.value.length > 50) {
        code.classList.add('is-invalid');
        document.getElementById('code-error').textContent = 'Designation code must not exceed 50 characters.';
        isValid = false;
    }
    
    // Validate Name
    const name = document.getElementById('name');
    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        document.getElementById('name-error').textContent = 'Designation name is required.';
        isValid = false;
    } else if (name.value.length > 255) {
        name.classList.add('is-invalid');
        document.getElementById('name-error').textContent = 'Designation name must not exceed 255 characters.';
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        e.stopPropagation();
    }
});
</script>
@endsection

