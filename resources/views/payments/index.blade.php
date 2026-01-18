@extends('layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payments Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Payments</h5>
        <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
             Record Payment
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Invoice #</th>
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_id }}</td>
                        <td><a href="{{ route('invoices.show', $payment->invoice) }}">{{ $payment->invoice->invoice_number }}</a></td>
                        <td>Rs.{{ number_format($payment->amount_paid, 2) }}</td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td><span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span></td>
                        <td>{{ $payment->reference_number ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No payments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection


