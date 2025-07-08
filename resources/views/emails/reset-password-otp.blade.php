<!DOCTYPE html>
<html>

<head>
    <title>Reset Password OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            background-color: #f3f4f6;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <p>Halo,</p>
        <p>Anda telah meminta untuk mereset password akun Anda. Berikut adalah kode OTP Anda:</p>

        <div class="otp-code">
            {{ $otp }}
        </div>

        <p>Kode OTP ini akan kadaluarsa dalam 15 menit.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

        <p>Terima kasih,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>