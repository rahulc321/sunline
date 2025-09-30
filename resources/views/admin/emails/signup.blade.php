<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account Created</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        
        <!-- Header -->
        <!-- <div style="background-color: #1976d2; color: #ffffff; text-align: center; padding: 20px; border-radius: 8px 8px 0 0;">
        <img src="{{env('LOGO')}}" alt="logo" class="desktop-logo" style="height:100px">    
        <h1 style="margin: 0; font-size: 24px;">🎉 Your Account is Ready 🎉</h1>
        </div> -->

        <div style="background-color: #004aad; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">{{ env('COMPANY') }}            </h1>
            <p style="margin: 5px 0 0; font-size: 14px;">{{env('TAG_LINE')}}</p>
            <h1 style="margin: 0; font-size: 24px;">🎉 Your Account is Ready 🎉</h1>
        </div>
        
        <!-- Body -->
        <div style="padding: 20px; color: #333333;">
            <p style="font-size: 16px;">Dear <strong>{{ $data['name'] }}</strong>,</p>

            <p style="font-size: 16px;">
                👉 Your account has been successfully created. Below are your login credentials:
            </p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background-color: #f1f1f1; border: 1px solid #ddd;">
                    <td style="padding: 10px; font-weight: bold; border: 1px solid #ddd;">Email</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $data['email'] }}</td>
                </tr>
                <tr style="background-color: #f9f9f9; border: 1px solid #ddd;">
                    <td style="padding: 10px; font-weight: bold; border: 1px solid #ddd;">Password</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $data['password'] }}</td>
                </tr>
            </table>
 
            <p style="font-size: 14px; color: #666;">
                If you need any assistance, feel free to reach out to our support team.
            </p>

            <p style="font-size: 14px; color: #666;">
                Best regards,<br>
                <strong>The CRM Admin Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; background: #e0e0e0; padding: 10px; font-size: 12px; color: #666666; border-radius: 0 0 8px 8px;">
            &copy; {{ date('Y') }} Sunline. All rights reserved.
        </div>
    </div>
</body>
</html>
