<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #eeeeee;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
            padding: 20px;
            color: #555;
        }

        .otp {
            font-size: 26px;
            font-weight: bold;
            color: #4CAF50;
            margin: 20px 0;
            text-align: center;
            padding: 15px;
            background-color: #f4f4f4;
            border-radius: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Hello {{ $username }},</p>
            <p>We received a request to reset your password. Please use the One-Time Password (OTP) below to verify your
                identity and proceed with resetting your password.</p>
            <div class="otp">
                {{ $otp }}
            </div>
            <p>If you did not request this, please ignore this email or contact our support team for further assistance.
            </p>
            <p>For security reasons, the OTP will expire in 10 minutes. Please ensure you use it within this time frame.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} nioke studio. All Rights Reserved.</p>
            <p>If you have any questions, feel free to <a href="mailto:nioke8090@gmail.com">contact our support team</a>.
            </p>
        </div>
    </div>
</body>

</html>
