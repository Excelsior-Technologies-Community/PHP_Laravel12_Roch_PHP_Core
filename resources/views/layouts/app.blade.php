<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="{{ session('theme', 'dark') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.app_name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #111827;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --accent: #38bdf8;
        }

        [data-theme="light"] {
            --bg-primary: #f1f5f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --accent: #0ea5e9;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .navbar-custom {
            background: rgba(15, 23, 42, .95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .navbar-custom {
            background: rgba(255, 255, 255, .95);
        }

        .brand-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent) !important;
            letter-spacing: .5px;
        }

        .main-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
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

        [data-theme="light"] .alert-success {
            background: #dcfce7;
            border: 1px solid #16a34a;
            color: #052e16;
        }

        [data-theme="light"] .alert-danger {
            background: #fee2e2;
            border: 1px solid #dc2626;
            color: #450a0a;
        }

        .form-control, .form-select {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .form-control:focus, .form-select:focus {
            background: var(--bg-primary);
            color: var(--text-primary);
            border-color: var(--accent);
            box-shadow: 0 0 0 .2rem rgba(56, 189, 248, .25);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
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
            color: var(--text-primary);
        }

        .table thead {
            background: var(--bg-secondary);
        }

        .table tbody tr {
            border-color: var(--border-color);
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, .04);
        }

        [data-theme="light"] .table tbody tr:hover {
            background: rgba(0, 0, 0, .04);
        }

        .card-dark {
            background: linear-gradient(135deg, var(--bg-secondary), var(--bg-primary));
            border: 1px solid var(--border-color);
            border-radius: 18px;
            color: var(--text-primary);
        }

        .glass-effect {
            background: rgba(30, 41, 59, .75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        [data-theme="light"] .glass-effect {
            background: rgba(255, 255, 255, .75);
            border: 1px solid rgba(0, 0, 0, .08);
        }

        .theme-toggle {
            width: 50px;
            height: 28px;
            border-radius: 14px;
            background: var(--border-color);
            border: none;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--accent);
            top: 3px;
            left: 3px;
            transition: all 0.3s ease;
        }

        [data-theme="light"] .theme-toggle::after {
            left: 25px;
        }

        .language-selector .btn {
            padding: 4px 10px;
            font-size: 0.8rem;
            border-radius: 6px;
            margin: 0 2px;
        }

        .language-selector .btn.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .custom-toast {
            min-width: 300px;
            padding: 15px 20px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
            margin-bottom: 10px;
        }

        .custom-toast.success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .custom-toast.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .custom-toast.info {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateX(100%); }
        }

        .dt-buttons .btn {
            padding: 6px 12px !important;
            font-size: 0.85rem !important;
            border-radius: 8px !important;
            margin-right: 5px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            margin: 0 2px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: white !important;
        }

        .dataTables_length select {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 6px;
            padding: 4px 8px;
        }

        .dataTables_filter input {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 6px;
            padding: 6px 12px;
        }

        .dataTables_filter input:focus {
            border-color: var(--accent);
            outline: none;
        }

        [data-theme="light"] .page-link {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        [data-theme="light"] .page-link:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        [data-theme="light"] .pagination .active .page-link {
            background: var(--accent);
            border-color: var(--accent);
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow">
        <div class="container">
            <a class="navbar-brand brand-logo" href="{{ route('users.index') }}">
                <i class="bi bi-people-fill"></i>
                {{ __('messages.app_name') }}
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="language-selector">
                    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-outline-secondary {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                    <a href="{{ route('lang.switch', 'gu') }}" class="btn btn-outline-secondary {{ app()->getLocale() == 'gu' ? 'active' : '' }}">ગુ</a>
                    <a href="{{ route('lang.switch', 'hi') }}" class="btn btn-outline-secondary {{ app()->getLocale() == 'hi' ? 'active' : '' }}">हि</a>
                </div>

                <a href="{{ route('theme.toggle') }}" class="theme-toggle" title="{{ session('theme', 'dark') == 'dark' ? __('messages.light_mode') : __('messages.dark_mode') }}">
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <div class="toast-container" id="toastContainer"></div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Validation Errors</strong>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `custom-toast ${type}`;
            toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}-fill me-2"></i>${message}`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'fadeOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>

    @stack('scripts')

</body>

</html>
