@extends('layouts.app')

@section('title', 'Create CN Book')
@section('page-title', 'Create CN Book')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create New CN Book</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('cn-books.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="book_number" class="form-label">Book Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('book_number') is-invalid @enderror" 
                           id="book_number" name="book_number" value="{{ old('book_number') }}" required>
                    <small class="form-text text-muted">Unique identifier (e.g., BOOK-001)</small>
                    @error('book_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="book_name" class="form-label">Book Name</label>
                    <input type="text" class="form-control" id="book_name" name="book_name" 
                           value="{{ old('book_name') }}" placeholder="Optional descriptive name">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="city_code" class="form-label">City Code</label>
                    <select class="form-select" id="city_code" name="city_code">
                        <option value="">Select City (Optional)</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->code }}" {{ old('city_code') == $city->code ? 'selected' : '' }}>
                                {{ $city->code }} - {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="system_year" class="form-label">System Year</label>
                    <input type="text" class="form-control" id="system_year" name="system_year" 
                           value="{{ old('system_year', session('system_year', '2526')) }}" 
                           placeholder="e.g., 2526">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="issue_date" class="form-label">Issue Date</label>
                    <input type="date" class="form-control" id="issue_date" name="issue_date" 
                           value="{{ old('issue_date', date('Y-m-d')) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="start_number" class="form-label">Start Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('start_number') is-invalid @enderror" 
                           id="start_number" name="start_number" value="{{ old('start_number') }}" 
                           min="1" required>
                    @error('start_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="end_number" class="form-label">End Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('end_number') is-invalid @enderror" 
                           id="end_number" name="end_number" value="{{ old('end_number') }}" 
                           min="1" required>
                    <small class="form-text text-muted">Must be greater than start number</small>
                    @error('end_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="expiry_date" class="form-label">Expiry Date (Optional)</label>
                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                           value="{{ old('expiry_date') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create CN Book</button>
                <a href="{{ route('cn-books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startNumber = document.getElementById('start_number');
        const endNumber = document.getElementById('end_number');
        
        // Update end number min when start number changes
        startNumber.addEventListener('change', function() {
            endNumber.min = parseInt(this.value) + 1;
        });
    });
</script>
@endpush
@endsection

