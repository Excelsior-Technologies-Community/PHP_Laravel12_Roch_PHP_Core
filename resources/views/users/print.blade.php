<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.app_name') }} - {{ __('messages.print') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f4f4f4;
            font-weight: bold;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
            padding: 3px 8px;
            border-radius: 4px;
        }
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print mb-3 text-center">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> {{ __('messages.print') }}
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            Close
        </button>
    </div>

    <div class="header">
        <h1>{{ __('messages.app_name') }}</h1>
        <p>{{ __('messages.print') }} - {{ date('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->status == 'active')
                    <span class="badge-active">{{ __('messages.active') }}</span>
                    @else
                    <span class="badge-inactive">{{ __('messages.inactive') }}</span>
                    @endif
                </td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">{{ __('messages.no_users') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ __('messages.total_users') }}: {{ count($users) }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>

</body>
</html>
