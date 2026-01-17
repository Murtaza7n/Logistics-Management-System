@extends('layouts.app')

@section('title', 'Admin Dashboard - Logistics Management System')
@section('page-title', 'Admin Dashboard')

@section('content')
@if(auth()->user()->isAdmin())
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
    .dashboard-container {
        padding: 1.5rem 0;
        padding-bottom: 6rem;
    }
    
    /* Summary Cards */
    .summary-card {
        background: linear-gradient(135deg, var(--metallic-silver) 0%, #8a8d90 100%);
        border-radius: 12px;
        padding: 1.5rem;
        color: var(--black);
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        border-left: 4px solid var(--orange-primary);
    }
    
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }
    
    .summary-card.primary {
        background: linear-gradient(135deg, var(--orange-primary) 0%, #ff8c5a 100%);
        color: white;
        border-left-color: #ff8c5a;
    }
    
    .summary-card.success {
        background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%);
        color: white;
        border-left-color: #5cb85c;
    }
    
    .summary-card.warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffd54f 100%);
        color: var(--black);
        border-left-color: #ffd54f;
    }
    
    .summary-card.danger {
        background: linear-gradient(135deg, #dc3545 0%, #e57373 100%);
        color: white;
        border-left-color: #e57373;
    }
    
    .summary-card.info {
        background: linear-gradient(135deg, #17a2b8 0%, #4dd0e1 100%);
        color: white;
        border-left-color: #4dd0e1;
    }
    
    .summary-card h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }
    
    .summary-card p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin: 0.5rem 0 0 0;
        font-weight: 500;
    }
    
    .summary-card .card-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
    }
    
    /* Chart Container */
    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .chart-container h5 {
        margin-bottom: 1rem;
        color: var(--black);
        font-weight: 600;
        border-bottom: 2px solid var(--orange-primary);
        padding-bottom: 0.5rem;
    }
    
    /* Problem CNs Table */
    .problem-cns-table {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    
    .problem-cns-table h5 {
        margin-bottom: 1rem;
        color: var(--black);
        font-weight: 600;
        border-bottom: 2px solid var(--orange-primary);
        padding-bottom: 0.5rem;
    }
    
    .cn-row {
        padding: 0.75rem;
        border-bottom: 1px solid #e9ecef;
        transition: background 0.2s ease;
        cursor: pointer;
    }
    
    .cn-row:hover {
        background: #f8f9fa;
    }
    
    .cn-row.delayed {
        background: #fff3cd;
        border-left: 4px solid #dc3545;
    }
    
    .cn-row.pending {
        border-left: 4px solid #ffc107;
    }
    
    /* Staff Overview */
    .staff-overview {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    
    .staff-overview h5 {
        margin-bottom: 1rem;
        color: var(--black);
        font-weight: 600;
        border-bottom: 2px solid var(--orange-primary);
        padding-bottom: 0.5rem;
    }
    
    .staff-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }
    
    /* Alerts Panel */
    .alerts-panel {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    
    .alerts-panel h5 {
        margin-bottom: 1rem;
        color: var(--black);
        font-weight: 600;
        border-bottom: 2px solid var(--orange-primary);
        padding-bottom: 0.5rem;
    }
    
    .alert-item {
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-item.warning {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        color: #856404;
    }
    
    .alert-item.danger {
        background: #f8d7da;
        border-left: 4px solid #dc3545;
        color: #721c24;
    }
    
    .alert-item .alert-icon {
        font-size: 1.5rem;
    }
    
    .city-bar {
        cursor: pointer;
        transition: opacity 0.2s ease;
    }
    
    .city-bar:hover {
        opacity: 0.8;
    }
    
    @media (max-width: 1200px) {
        .col-lg-2-4 {
            flex: 0 0 33.333333% !important;
            max-width: 33.333333% !important;
        }
    }
    
    @media (max-width: 768px) {
        .col-lg-2-4 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
        
        .summary-card h3 {
            font-size: 2rem;
        }
        
        .summary-card .card-icon {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .col-lg-2-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
</style>

<div class="dashboard-container">
    <!-- 1. Top Summary Cards (5 ONLY) -->
    <div class="row g-3 mb-4" style="display: flex; flex-wrap: wrap;">
        <div class="col-6 col-md-4 col-lg-2-4" style="flex: 0 0 20%; max-width: 20%;">
            <div class="summary-card primary position-relative">
                <h3>{{ number_format($stats['today_cn_entries']) }}</h3>
                <p>Today CN Entries</p>
                <i class="bi bi-journal-text card-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4" style="flex: 0 0 20%; max-width: 20%;">
            <div class="summary-card warning position-relative">
                <h3>{{ number_format($stats['pending_deliveries']) }}</h3>
                <p>Pending Deliveries</p>
                <i class="bi bi-clock-history card-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4" style="flex: 0 0 20%; max-width: 20%;">
            <div class="summary-card success position-relative">
                <h3>{{ number_format($stats['delivered_today']) }}</h3>
                <p>Delivered Today</p>
                <i class="bi bi-check-circle card-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4" style="flex: 0 0 20%; max-width: 20%;">
            <div class="summary-card danger position-relative">
                <h3>{{ number_format($stats['delayed_shipments']) }}</h3>
                <p>Delayed Shipments</p>
                <i class="bi bi-x-circle card-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2-4" style="flex: 0 0 20%; max-width: 20%;">
            <div class="summary-card info position-relative">
                <h3>{{ number_format($stats['active_cities']) }}</h3>
                <p>Active Cities</p>
                <i class="bi bi-geo-alt card-icon"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- 2. City-Wise Workload (Bar Chart) -->
            <div class="chart-container">
                <h5><i class="bi bi-bar-chart"></i> City-Wise Workload</h5>
                <canvas id="cityWorkloadChart" height="80"></canvas>
            </div>

            <!-- 4. CN Trend (Last 7 Days) -->
            <div class="chart-container">
                <h5><i class="bi bi-graph-up"></i> CN Entries Trend (Last 7 Days)</h5>
                <canvas id="cnTrendChart" height="80"></canvas>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- 6. Alerts Panel -->
            <div class="alerts-panel">
                <h5><i class="bi bi-bell"></i> Alerts</h5>
                @if(count($alerts) > 0)
                    @foreach($alerts as $alert)
                    <div class="alert-item {{ $alert['type'] }}">
                        <i class="bi {{ $alert['icon'] }} alert-icon"></i>
                        <div class="flex-grow-1">
                            <strong>{{ $alert['message'] }}</strong>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-check-circle" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2 mb-0">No alerts at this time</p>
                    </div>
                @endif
            </div>

            <!-- 5. Staff Overview -->
            <div class="staff-overview">
                <h5><i class="bi bi-people"></i> Staff Overview</h5>
                <div class="staff-stat">
                    <span>Total Staff:</span>
                    <strong>{{ number_format($staffOverview['total_staff']) }}</strong>
                </div>
                <div class="staff-stat">
                    <span>Active Staff:</span>
                    <strong>{{ number_format($staffOverview['active_staff']) }}</strong>
                </div>
                @if(count($cityWiseStaff) > 0)
                <div class="mt-3">
                    <small class="text-muted d-block mb-2">City-wise Staff:</small>
                    @foreach($cityWiseStaff->take(5) as $city)
                    <div class="staff-stat">
                        <span>{{ $city['name'] }}@if($city['code']) ({{ $city['code'] }})@endif:</span>
                        <strong>{{ $city['staff_count'] }}</strong>
                    </div>
                    @endforeach
                    @if(count($cityWiseStaff) > 5)
                    <small class="text-muted">+ {{ count($cityWiseStaff) - 5 }} more cities</small>
                    @endif
                </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-arrow-right"></i> View All Staff
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Top 10 Problem CNs -->
    <div class="problem-cns-table">
        <h5><i class="bi bi-exclamation-triangle"></i> Top 10 Problem CNs (Pending/Delayed)</h5>
        @if(count($problemCns) > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>CN Number</th>
                        <th>Customer</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Expected Date</th>
                        <th>Days Delayed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($problemCns as $cn)
                    <tr class="cn-row {{ $cn->is_delayed ? 'delayed' : 'pending' }}" 
                        onclick="window.location.href='{{ route('shipments.show', $cn->shipment_id) }}'">
                        <td><strong>{{ $cn->cn_number ?? 'N/A' }}</strong></td>
                        <td>{{ $cn->customer->name ?? 'N/A' }}</td>
                        <td>{{ $cn->entryCity->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $cn->is_delayed ? 'danger' : 'warning' }}">
                                {{ ucfirst(str_replace('-', ' ', $cn->status)) }}
                            </span>
                        </td>
                        <td>{{ $cn->delivery_date ? \Carbon\Carbon::parse($cn->delivery_date)->format('M d, Y') : 'Not Set' }}</td>
                        <td>
                            @if($cn->is_delayed)
                                <span class="badge bg-danger">{{ $cn->days_delayed }} days</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4">
            <i class="bi bi-check-circle" style="font-size: 2rem; opacity: 0.3;"></i>
            <p class="mt-2 mb-0">No problem CNs at this time</p>
        </div>
        @endif
    </div>
</div>

<script>
    // City-Wise Workload Chart
    const cityWorkloadCtx = document.getElementById('cityWorkloadChart').getContext('2d');
    new Chart(cityWorkloadCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($cityWorkload->pluck('name')) !!},
            datasets: [
                {
                    label: 'Total CNs',
                    data: {!! json_encode($cityWorkload->pluck('total_cns')) !!},
                    backgroundColor: 'rgba(255, 107, 53, 0.8)',
                    borderColor: 'rgb(255, 107, 53)',
                    borderWidth: 2
                },
                {
                    label: 'Pending CNs',
                    data: {!! json_encode($cityWorkload->pluck('pending_cns')) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: 'rgb(255, 193, 7)',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            const index = context.dataIndex;
                            const city = {!! json_encode($cityWorkload) !!}[index];
                            return `Click to view details`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const city = {!! json_encode($cityWorkload) !!}[index];
                    // Show city detail in modal or navigate
                    alert('City: ' + city.name + '\nTotal CNs: ' + city.total_cns + '\nPending CNs: ' + city.pending_cns);
                }
            }
        }
    });

    // CN Trend Chart (Last 7 Days)
    const cnTrendCtx = document.getElementById('cnTrendChart').getContext('2d');
    new Chart(cnTrendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($cnTrend)->pluck('day')) !!},
            datasets: [{
                label: 'CN Entries',
                data: {!! json_encode(collect($cnTrend)->pluck('count')) !!},
                borderColor: 'rgb(255, 107, 53)',
                backgroundColor: 'rgba(255, 107, 53, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            const date = {!! json_encode(collect($cnTrend)->pluck('date')) !!}[index];
                            return new Date(date).toLocaleDateString('en-US', { 
                                weekday: 'long', 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric' 
                            });
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

@else
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i> You don't have permission to access this page.
</div>
@endif
@endsection
