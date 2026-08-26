@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Dashboard Cards -->
    <div class="row g-3 mb-4">

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-primary text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $totalUsers }}</h3>
                    <small>{{ __('messages.total_users') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-success text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $todayUsers }}</h3>
                    <small>{{ __('messages.todays_users') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-info text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $activeUsers }}</h3>
                    <small>{{ __('messages.active_users') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-warning text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $inactiveUsers }}</h3>
                    <small>{{ __('messages.inactive_users') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-secondary text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $weeklyUsers }}</h3>
                    <small>{{ __('messages.weekly_users') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-lg bg-dark text-white rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold mb-1">{{ $monthlyUsers }}</h3>
                    <small>{{ __('messages.monthly_users') }}</small>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="card bg-dark border-secondary shadow-lg rounded-4 mb-4">
        <div class="card-body">
            <h5 class="text-light mb-3">
                <i class="bi bi-graph-up me-2"></i>{{ __('messages.user_growth') }}
            </h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Search + Filters -->
    <div class="card bg-dark border-secondary shadow-lg rounded-4 mb-4">
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET" class="row g-3 align-items-end">

                <div class="col-md-2">
                    <label class="form-label text-light small">{{ __('messages.from_date') }}</label>
                    <input type="date" name="from_date" value="{{ $fromDate }}" class="form-control bg-black text-light border-secondary form-control-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label text-light small">{{ __('messages.to_date') }}</label>
                    <input type="date" name="to_date" value="{{ $toDate }}" class="form-control bg-black text-light border-secondary form-control-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label text-light small">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select bg-black text-light border-secondary form-select-sm">
                        <option value="">{{ __('messages.all_status') }}</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-light small">{{ __('messages.search') }}</label>
                    <input type="text" name="search" value="{{ $search }}" class="form-control bg-black text-light border-secondary form-control-sm" placeholder="{{ __('messages.search_placeholder') }}">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-info btn-sm">
                        <i class="bi bi-search"></i> {{ __('messages.filter') }}
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> {{ __('messages.reset') }}
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Export + Add User -->
    <div class="card bg-dark border-secondary shadow-lg rounded-4 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('users.export.csv', request()->all()) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-filetype-csv"></i> {{ __('messages.export_csv') }}
                    </a>
                    <a href="{{ route('users.export.excel', request()->all()) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-filetype-xlsx"></i> {{ __('messages.export_excel') }}
                    </a>
                    <a href="{{ route('users.export.pdf', request()->all()) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-filetype-pdf"></i> {{ __('messages.export_pdf') }}
                    </a>
                    <a href="{{ route('users.print', request()->all()) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-printer"></i> {{ __('messages.print') }}
                    </a>
                </div>

                <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg"></i> {{ __('messages.add_user') }}
                </a>

            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card bg-dark border-secondary shadow-lg rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" id="usersTable">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th width="180">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->status == 'active')
                                <span class="badge bg-success">{{ __('messages.active') }}</span>
                                @else
                                <span class="badge bg-danger">{{ __('messages.inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> {{ __('messages.edit') }}
                                </a>
                                <a href="{{ route('users.delete', $user->id) }}"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('{{ __('messages.delete_confirm') }}')">
                                    <i class="bi bi-trash"></i> {{ __('messages.delete') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- Pagination -->
    @if ($users->lastPage() > 1)
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            @for ($i = 1; $i <= $users->lastPage(); $i++)
                <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
        </ul>
    </nav>
    @endif

</div>

<!-- STYLE -->
<style>
    .table-dark {
        --bs-table-bg: #111827;
        --bs-table-hover-bg: #1f2937;
        --bs-table-border-color: #374151;
    }

    .pagination {
        justify-content: center;
        gap: 8px;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        width: 42px;
        height: 42px;
        border-radius: 12px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #111827;
        border: 1px solid #374151;
        color: #f8fafc;
        font-weight: 600;
        transition: all .3s ease;
    }

    .page-link:hover {
        background: #06b6d4;
        border-color: #06b6d4;
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('userGrowthChart');
        if (ctx) {
            if (window.userChart) {
                window.userChart.destroy();
            }
            window.userChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: '{{ __("messages.user_growth") }}',
                        data: @json($chartData),
                        borderColor: '#38bdf8',
                        backgroundColor: 'rgba(56, 189, 248, 0.15)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#38bdf8',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 0
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: { color: '#e2e8f0', font: { size: 14 } }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#94a3b8' },
                            grid: { color: 'rgba(255,255,255,0.05)' }
                        },
                        y: {
                            ticks: { 
                                color: '#94a3b8',
                                stepSize: 1,
                                precision: 0
                            },
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            beginAtZero: true,
                            min: 0
                        }
                    }
                }
            });
        }
    });

    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#usersTable')) {
            $('#usersTable').DataTable().destroy();
        }
        $('#usersTable').DataTable({
            responsive: true,
            paging: false,
            info: false,
            searching: false,
            ordering: true,
            language: {
                emptyTable: '{{ __("messages.no_data") }}'
            }
        });
    });
</script>
@endpush

@endsection
