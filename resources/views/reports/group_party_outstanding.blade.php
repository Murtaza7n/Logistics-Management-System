@extends('layouts.app')

@section('title', 'Group/Party Outstanding with S/Tax')
@section('page-title', 'Group/Party Outstanding with S/Tax')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Group/Party Outstanding with S/Tax
    </h1>
    <p class="page-subtitle">Outstanding amounts by customer/party including sales tax</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Outstanding Parties ({{ $customers->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Party/Customer</th>
                        <th>Contact</th>
                        <th>Total Invoiced</th>
                        <th>Total Paid</th>
                        <th>Outstanding Amount</th>
                        <th>Sales Tax</th>
                        <th>Total Outstanding</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    @php
                        $totalInvoiced = $customer->invoices()->sum('total');
                        $totalPaid = $customer->invoices()->get()->sum(function($inv) {
                            return $inv->payments()->sum('amount_paid');
                        });
                        $outstanding = $totalInvoiced - $totalPaid;
                        $salesTax = $outstanding * 0.15; // Assuming 15% sales tax
                        $totalOutstanding = $outstanding + $salesTax;
                    @endphp
                    <tr>
                        <td><strong>{{ $customer->name }}</strong></td>
                        <td>{{ $customer->contact ?? 'N/A' }}</td>
                        <td>Rs.{{ number_format($totalInvoiced, 2) }}</td>
                        <td>Rs.{{ number_format($totalPaid, 2) }}</td>
                        <td>Rs.{{ number_format($outstanding, 2) }}</td>
                        <td>Rs.{{ number_format($salesTax, 2) }}</td>
                        <td><strong>Rs.{{ number_format($totalOutstanding, 2) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No outstanding amounts found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="4">Total Outstanding</th>
                        <th>Rs.{{ number_format($customers->sum('outstanding'), 2) }}</th>
                        <th>Rs.{{ number_format($customers->sum('outstanding') * 0.15, 2) }}</th>
                        <th>Rs.{{ number_format($customers->sum('outstanding') * 1.15, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

