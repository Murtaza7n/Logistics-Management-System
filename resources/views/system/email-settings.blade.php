@extends('layouts.app')

@section('title', 'E-mail Settings')
@section('page-title', 'E-mail Settings')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-envelope"></i> E-mail Settings
    </h1>
    <p class="page-subtitle">Configure email server and notification settings</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Email Configuration</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.update-email-settings') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_host" class="form-label">SMTP Host</label>
                        <input type="text" class="form-control @error('mail_host') is-invalid @enderror" 
                               id="mail_host" name="mail_host" 
                               value="{{ old('mail_host', config('mail.mailers.smtp.host')) }}">
                        @error('mail_host')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_port" class="form-label">SMTP Port</label>
                        <input type="number" class="form-control @error('mail_port') is-invalid @enderror" 
                               id="mail_port" name="mail_port" 
                               value="{{ old('mail_port', config('mail.mailers.smtp.port')) }}">
                        @error('mail_port')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_username" class="form-label">SMTP Username</label>
                        <input type="text" class="form-control @error('mail_username') is-invalid @enderror" 
                               id="mail_username" name="mail_username" 
                               value="{{ old('mail_username', config('mail.mailers.smtp.username')) }}">
                        @error('mail_username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_password" class="form-label">SMTP Password</label>
                        <input type="password" class="form-control @error('mail_password') is-invalid @enderror" 
                               id="mail_password" name="mail_password" 
                               placeholder="Leave blank to keep current">
                        @error('mail_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_from_address" class="form-label">From Email Address</label>
                        <input type="email" class="form-control @error('mail_from_address') is-invalid @enderror" 
                               id="mail_from_address" name="mail_from_address" 
                               value="{{ old('mail_from_address', config('mail.from.address')) }}">
                        @error('mail_from_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mail_from_name" class="form-label">From Name</label>
                        <input type="text" class="form-control @error('mail_from_name') is-invalid @enderror" 
                               id="mail_from_name" name="mail_from_name" 
                               value="{{ old('mail_from_name', config('mail.from.name')) }}">
                        @error('mail_from_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="mail_encryption" id="mail_encryption" value="tls" checked>
                    <label class="form-check-label" for="mail_encryption">
                        Use TLS Encryption
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Email Settings
            </button>
        </form>
    </div>
</div>
@endsection

