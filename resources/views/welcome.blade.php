<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ticket Booking System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            padding: 40px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 30px;
        }

        .buttons button {
            padding: 12px 25px;
            font-size: 1.1rem;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .buttons .login-btn {
            background-color: #3498db;
            color: white;
        }

        .buttons .login-btn:hover {
            background-color: #2980b9;
        }

        .buttons .register-btn {
            background-color: #2ecc71;
            color: white;
        }

        .buttons .register-btn:hover {
            background-color: #27ae60;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.9rem;
            color: #7f8c8d;
        }
    </style>

</head>

<body>

    <div class="container">
        <h1>Ticket Booking System</h1>

        <div class="buttons">
            <button class="login-btn" onclick="window.location.href='{{ route('auth.login') }}'">Login</button>
            <button class="register-btn" onclick="window.location.href='{{ route('auth.register') }}'">Register</button>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Ticket Booking System</p>
    </div>

</body>

</html>
