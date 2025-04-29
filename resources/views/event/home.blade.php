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
    <h2 class="text-center">Events</h2>

    <div id="event-container">
        @include('event._events', ['events' => $events])
    </div>
</div>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Document ready');

    $(document).on('change', '#no_of_events', function() {
        var limit = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('limit', limit);
        url.searchParams.set('page', 1);
        loadEvents(url.href);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        loadEvents(url);
    });

    function loadEvents(url) {
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#event-container').html(response.events);
                    $('#pagination-container').html(response.pagination);
                }
            },
            error: function(xhr) {
                console.log('Error fetching events.');
            }
        });
    }
});
</script>
@endsection
