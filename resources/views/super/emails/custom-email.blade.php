<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background-color: #004aad; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">{{ env('COMPANY') }}            </h1>
            <p style="margin: 5px 0 0; font-size: 14px;">{{env('TAG_LINE')}}</p>
        </div>

        <!-- Body -->
        <div style="padding: 20px; color: #333;">
            {!! $body !!}
        </div>

        <!-- Footer -->
        <div style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 12px; color: #666;">
            <p style="margin: 0;">&copy; {{ date('Y') }} {{ env('COMPANY') }}. All rights reserved.</p>
             
        </div>
    </div>
</body>
</html>
