<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['subject'] }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2c3e50;">Hello {{ $data['recipient_name'] }}!</h2>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
            {!! nl2br(e($data['message'])) !!}
        </div>
        
        <hr style="border: 1px solid #eee; margin: 30px 0;">
        
        <p style="color: #7f8c8d; font-size: 14px;">
            Sent at: {{ now()->format('F j, Y \a\t g:i A') }}
        </p>
    </div>
</body>
</html>