<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking System</title>

    <!-- Bootstrap CSS -->
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
    <!-- Success Popup -->
    <!-- Alerts -->
    <div id="success-alert" class="custom-alert" style="background-color:#28a745;">Booking Successful!</div>
    <div id="error-alert" class="custom-alert" style="background-color:#dc3545;">Something went wrong!</div>
    <div id="cancel-alert" class="custom-alert" style="background-color:#ffc107; color: #000;">Booking Cancelled!</div>





    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" style="font-weight: bold; color: black; font-size: 20px; font-family: 'Poppins', sans-serif;" href="#">Ticket Booking System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" style="font-weight: bold; color: black; font-size: 16px; font-family: 'Poppins', sans-serif;">
                    <a class="nav-link" style="color: black;" href="{{ route('auth.logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        @yield('content') <!-- This is where the content from other views will be injected -->
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        function showAlert(type, message) {
            let alertBox;

            if (type === 'success') {
                alertBox = $('#success-alert');
            } else if (type === 'error') {
                alertBox = $('#error-alert');
            } else if (type === 'cancel') {
                alertBox = $('#cancel-alert');
            }

            if (alertBox) {
                alertBox.text(message).fadeIn();
                setTimeout(function() {
                    alertBox.fadeOut();
                }, 2000); // 2 seconds
            }
        }
    </script>
</body>

</html>
