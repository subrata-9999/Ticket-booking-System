<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking System</title>
    <!-- Add any other meta tags or CSS files here -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.2);
            /* Light glass effect */
            backdrop-filter: blur(10px);
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar .nav-link,
        .navbar .navbar-brand {
            color: #fff;
            font-weight: 600;
        }

        .navbar .nav-link:hover,
        .navbar .navbar-brand:hover {
            color: #f0f0f0;
        }

        .custom-alert {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            font-weight: bold;
            font-size: 16px;
        }
    </style>


</head>
<body>
    <div class="container">
        <!-- Navigation Bar (optional) -->


        <!-- Main Content -->
        @yield('content') <!-- This is where the content from other views will be injected -->
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
