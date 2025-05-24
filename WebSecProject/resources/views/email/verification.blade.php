<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; padding: 0; }
        .container { max-width: 480px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px 24px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h2 {
            color: #007bff;
            font-weight: bold;
            margin: 0;
        }
        .header span {
            color: #ff5722;
            font-weight: bold;
        }
        .content { color: #444; font-size: 16px; }
        .button {
            display: block;
            width: 200px;
            margin: 32px auto 0 auto;
            padding: 12px 0;
            background: #007bff;
            color: #fff !important;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 4px #0002;
            transition: background 0.2s;
        }
        .button:hover { background: #ff5722; }
        .footer { margin-top: 32px; text-align: center; color: #888; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to <span>BiT</span>!</h2>
        </div>
        <div class="content">
            <p>Hi <strong>{{ $name }}</strong>,</p>
            <p>Thank you for registering with <strong>BiT</strong>! To complete your registration, please verify your email address by clicking the button below:</p>
            <a href="{{ $link }}" class="button" target="_blank">Verify Email</a>
            <p style="margin-top:32px; color:#888; font-size:14px;">If you did not create an account, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} BiT. All rights reserved.
        </div>
    </div>
</body>
</html>
