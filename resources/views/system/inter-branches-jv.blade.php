@extends('layouts.app')

@section('title', 'Inter Branches J.V Code')
@section('page-title', 'Inter Branches Journal Voucher Code')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-building"></i> Inter Branches J.V Code
    </h1>
    <p class="page-subtitle">Manage inter-branch journal voucher codes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Journal Voucher Codes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Branch Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No J.V codes configured</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJvCodeModal">
                <i class="bi bi-plus-circle"></i> Add J.V Code
            </button>
        </div>
    </div>
</div>

<!-- Add J.V Code Modal -->
<div class="modal fade" id="addJvCodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Inter Branch J.V Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Branch Name</label>
                        <input type="text" class="form-control" name="branch_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

