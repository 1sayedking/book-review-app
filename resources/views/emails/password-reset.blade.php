<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Inline Bootstrap styles manually or via an email CSS inliner tool */
       *{
        font-size: 18px;
       }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            background-color: #4CAF50;
            border: 1px solid transparent;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .container {
            border: 2px solid black;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .header {
            
            margin-bottom: 20px;
        }

        .footer {
            font-size: 20px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            
            <p>Email from <strong style="color: #45a049">{{ config('app.name') }}</strong></p>
        </div>
          <h1 style="text-align: center">Password Reset Request</h1>
        <p>Hello, <strong>{{ @$user->name }}</strong></p>
        <p>You requested to reset your password:</p>

        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('account.resetPassword', $token) }}" class="btn">
                Reset Password
            </a>
        </div>

        <p>If you did not request this, please ignore this email.</p>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
