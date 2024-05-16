<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OTP Verification</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 24px;
        }

        p {
            margin-bottom: 16px;
        }

        strong {
            color: #4285f4;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <p>Your Forgot Password OTP is: <a>{{ $pdf->download('dfsld.pdf') }}</a></p>
    <p>Please use this OTP to verify your account.</p>
    <p>If you did not request this OTP, please ignore this email.</p>
    <p>Thank you!</p>
</body>

</html>
