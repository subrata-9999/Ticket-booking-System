
<div style="text-align: right; width: 100%; margin-bottom: 20px;">
    <button class="btn btn-primary" id="back-to-events-page">
        Back To Events Page ->
    </button>
</div>
<div id="bookings-list" class="bookings-container">
    @if(count($bookings) > 0)
        @foreach($bookings as $booking)
            <div class="booking-card">
                <div class="booking-card-body">
                    <h5 class="booking-card-title">{{ $booking['event_name'] }}</h5>
                    <p class="booking-card-text">
                        <strong>Venue:</strong> {{ $booking['event_venue'] }} <br>
                        <strong>Event Date:</strong> {{ \Carbon\Carbon::parse($booking['event_date'])->format('F d, Y') }} <br>
                        <strong>Ticket Holder:</strong> {{ $booking['user_name'] }} <br>
                        <strong>Booking Time:</strong> {{ \Carbon\Carbon::parse($booking['created_at'])->format('F d, Y h:i A') }}
                    </p>
                    <a href="#" data-booking_id="{{ $booking['id'] }}" class="btn btn-danger booking-card-button delete_ticket">Cancel Ticket</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="booking-card">
            <div class="booking-card-body text-center">
                <h5 class="booking-card-title">No Booking Available</h5>
                <p class="booking-card-text">You have no active bookings at the moment.</p>
            </div>
        </div>
    @endif
</div>


<!-- Confirm Delete Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Cancel Ticket Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span> <!-- X mark -->
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel your ticket? This action cannot be undone and your seat will be released.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep Ticket</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Yes, Cancel Ticket</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

document.getElementById('back-to-events-page').addEventListener('click', function() {
        window.location.href = "{{ route('event.index') }}";
    });
    $(document).ready(function() {
        var bookingIdToDelete = null;

        // When user clicks on Cancel Ticket button
        $('.delete_ticket').on('click', function(e) {
            e.preventDefault();
            bookingIdToDelete = $(this).data('booking_id'); // store booking id
            $('#deleteConfirmModal').modal('show'); // show modal
        });

        // When user confirms deletion
        $('#confirmDeleteBtn').on('click', function() {
            if (bookingIdToDelete) {
                $.ajax({
                    url: '/booking/delete/' + bookingIdToDelete,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#deleteConfirmModal').modal('hide'); // hide modal
                            showAlert('success', response.message); // show success alert

                            //redirect to the booking page
                            setTimeout(function(){
                                location.reload();
                            }, 2000); // Redirect after 2 seconds

                        } else {
                            showAlert('error', response.message); // show error alert
                        }
                    },
                    error: function(xhr) {
                        console.log('Error deleting booking.', xhr);
                        showAlert('cancel', 'Something went wrong!');

                    }
                });
            }
        });
    });
</script>

<style>
    .bookings-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .booking-card {
        width: 28%; /* Increased width */
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 20px;
        text-align: left; /* Align text to left */
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
        position: relative; /* Make sure the button can be positioned at the right */
    }

    .booking-card-body {
        padding: 15px;
    }

    .booking-card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        text-transform: capitalize;
    }

    .booking-card-text {
        font-size: 1rem;
        color: #555;
        margin-bottom: 20px;
    }

    .booking-card-text strong {
        color: #333;
    }

    .booking-card-button {
        padding: 10px 20px;
        font-size: 1rem;
        background-color: #e74c3c;
        border: none;
        color: #ffffff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        position: absolute;
        right: 20px; /* Align to the right */
        bottom: 20px; /* Add space from the bottom */
    }

    .booking-card-button:hover {
        background-color: #c0392b;
        cursor: pointer;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(31, 38, 135, 0.45);
    }

    /* Responsive Layout */
    @media (max-width: 992px) {
        .booking-card {
            width: 48%;
        }
    }

    @media (max-width: 768px) {
        .booking-card {
            width: 98%;
        }
    }
</style>
