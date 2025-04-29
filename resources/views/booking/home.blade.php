@extends('layouts.app')

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
</style>


@section('content')
<div class="container mt-4">
    <h2 class="text-center">Bookings</h2>

    <div id="event-container">
        @include('booking._booking', ['bookings' => $bookings])
    </div>
</div>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
@endsection
