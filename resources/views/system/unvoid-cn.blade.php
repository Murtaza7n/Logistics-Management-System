@extends('layouts.app')

@section('title', 'Un-Void C/N')
@section('page-title', 'Un-Void Consignment Note')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-arrow-counterclockwise"></i> Un-Void C/N
    </h1>
    <p class="page-subtitle">Restore voided consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Un-Void Consignment Note</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.process-unvoid-cn') }}" onsubmit="return confirm('Are you sure you want to un-void this C/N?');">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cn_number" class="form-label">C/N Number</label>
                        <input type="text" class="form-control @error('cn_number') is-invalid @enderror" 
                               id="cn_number" name="cn_number" 
                               placeholder="Enter C/N number" required>
                        @error('cn_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Un-Void</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                  id="reason" name="reason" rows="3" 
                                  placeholder="Enter reason for un-voiding" required></textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> <strong>Note:</strong> Un-voiding a C/N will restore it to its previous status. This action will be logged in the system.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Un-Void C/N
            </button>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0">Recently Voided C/Ns</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N Number</th>
                        <th>Voided Date</th>
                        <th>Voided By</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No voided C/Ns found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

