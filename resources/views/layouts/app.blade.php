<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 CRUD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(15, 23, 42, .95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #334155;
        }

        .brand-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #38bdf8 !important;
            letter-spacing: .5px;
        }

        .main-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
            padding: 25px;
        }

        .alert-success {
            background: #052e16;
            border: 1px solid #16a34a;
            color: #dcfce7;
        }

        .alert-danger {
            background: #450a0a;
            border: 1px solid #dc2626;
            color: #fee2e2;
        }

        .form-control {
            background: #0f172a;
            border: 1px solid #475569;
            color: white;
        }

        .form-control:focus {
            background: #0f172a;
            color: white;
            border-color: #38bdf8;
            box-shadow: 0 0 0 .2rem rgba(56, 189, 248, .25);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: white;
        }

        .table {
            color: #e2e8f0;
        }

        .table thead {
            background: #334155;
        }

        .table tbody tr {
            border-color: #334155;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, .04);
        }

        .card-dark {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid #334155;
            border-radius: 18px;
            color: white;
        }

        .page-link {
            background: #1e293b;
            border-color: #475569;
            color: white;
        }

        .page-link:hover {
            background: #0ea5e9;
            border-color: #0ea5e9;
            color: white;
        }

        .pagination .active .page-link {
            background: #0ea5e9;
            border-color: #0ea5e9;
        }

        .glass-effect {
            background: rgba(30, 41, 59, .75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .08);
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow">

        <div class="container">

            <a class="navbar-brand brand-logo" href="{{ route('users.index') }}">

                <i class="bi bi-people-fill"></i>
                User Management System

            </a>

        </div>

    </nav>

    <div class="container py-4">

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button class="btn-close btn-close-white" data-bs-dismiss="alert"></button>

            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Validation Errors
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="main-card glass-effect">

            @yield('content')

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>