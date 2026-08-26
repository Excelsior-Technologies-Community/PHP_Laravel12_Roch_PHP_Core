<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #10b981, #059669); padding: 30px; text-align: center; }
        .header.updated { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .header h1 { color: #fff; margin: 0; font-size: 24px; }
        .body { padding: 30px; }
        .body p { color: #333; font-size: 16px; line-height: 1.6; }
        .user-info { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .user-info p { margin: 8px 0; }
        .label { font-weight: bold; color: #64748b; }
        .footer { background: #1e293b; padding: 20px; text-align: center; }
        .footer p { color: #94a3b8; font-size: 14px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header {{ $type === 'updated' ? 'updated' : '' }}">
            <h1>{{ $type === 'created' ? __('messages.new_user_subject') : __('messages.updated_user_subject') }}</h1>
        </div>
        <div class="body">
            <p>{{ $type === 'created' ? __('messages.new_user_message') : __('messages.updated_user_message') }}</p>
            <div class="user-info">
                <p><span class="label">{{ __('messages.name') }}:</span> {{ $user->name }}</p>
                <p><span class="label">{{ __('messages.email') }}:</span> {{ $user->email }}</p>
                <p><span class="label">{{ __('messages.status') }}:</span> {{ ucfirst($user->status) }}</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
