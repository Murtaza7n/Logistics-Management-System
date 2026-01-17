@extends('layouts.app')

@section('title', 'Change Year')
@section('page-title', 'Change System Year')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Change System Year
    </h1>
    <p class="page-subtitle">Update the current system year for data segregation</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Current Year: {{ $currentYear }}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.update-year') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <select class="form-select @error('year') is-invalid @enderror" id="year" name="year" required>
                            <option value="2526" {{ $currentYear == '2526' ? 'selected' : '' }}>2526</option>
                            <option value="2425" {{ $currentYear == '2425' ? 'selected' : '' }}>2425</option>
                            <option value="2324" {{ $currentYear == '2324' ? 'selected' : '' }}>2324</option>
                            <option value="2223" {{ $currentYear == '2223' ? 'selected' : '' }}>2223</option>
                            <option value="2122" {{ $currentYear == '2122' ? 'selected' : '' }}>2122</option>
                            <option value="2021" {{ $currentYear == '2021' ? 'selected' : '' }}>2021</option>
                        </select>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                         Change Year
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

