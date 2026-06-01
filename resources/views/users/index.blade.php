@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Dashboard Cards -->
        <div class="row g-4 mb-4">

            <div class="col-md-6">

                <div class="card border-0 shadow-lg bg-primary text-white rounded-4">

                    <div class="card-body text-center py-4">

                        <h1 class="fw-bold">
                            {{ $totalUsers }}
                        </h1>

                        <h5>
                            Total Users
                        </h5>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card border-0 shadow-lg bg-success text-white rounded-4">

                    <div class="card-body text-center py-4">

                        <h1 class="fw-bold">
                            {{ $todayUsers }}
                        </h1>

                        <h5>
                            Today's Users
                        </h5>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search + Add User -->
        <div class="card bg-dark border-secondary shadow-lg rounded-4 mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <form action="{{ route('users.index') }}" method="GET" class="d-flex" style="width:350px;">

                        <input type="text" name="search" class="form-control me-2 bg-black text-light border-secondary"
                            placeholder="Search Name or Email..." value="{{ request('search') }}">

                        <button class="btn btn-info">
                            Search
                        </button>

                    </form>

                    <a href="{{ route('users.create') }}" class="btn btn-success">

                        + Add User

                    </a>

                </div>

            </div>

        </div>

        <!-- Users Table -->
        <div class="card bg-dark border-secondary shadow-lg rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-dark table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="180">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td>{{ $user->id }}</td>

                                    <td>{{ $user->name }}</td>

                                    <td>{{ $user->email }}</td>

                                    <td>

                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">

                                            Edit

                                        </a>

                                        <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete User?')">

                                            Delete

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center py-4">

                                        No Users Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Number Pagination Only -->

        @if ($users->lastPage() > 1)

            <nav class="mt-4">

                <ul class="pagination justify-content-center">

                    @for ($i = 1; $i <= $users->lastPage(); $i++)

                        <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">

                            <a class="page-link" href="{{ $users->url($i) }}">

                                {{ $i }}

                            </a>

                        </li>

                    @endfor

                </ul>

            </nav>

        @endif

    </div>

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

            background: linear-gradient(135deg,
                    #06b6d4,
                    #3b82f6);

            border-color: transparent;

            color: white;

            box-shadow:
                0 5px 15px rgba(59, 130, 246, .4);

        }
    </style>

@endsection