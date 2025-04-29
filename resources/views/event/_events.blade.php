<div class="d-flex justify-content-between align-items-center mb-3" style="gap: 20px;">
    <!-- Left: Show Your Tickets button -->
    <div>
        <button class="btn btn-primary" id="back-to-booking-page">
            Show Your Tickets
        </button>
    </div>

    <!-- Right: Show per page dropdown -->
    <div class="d-flex align-items-center">
        <label for="limit" class="mr-2 mb-0">Show per page:</label>
        <select id="limit" class="form-control" style="width: auto;">
            <option value="8" {{ $events->perPage() == 8 ? 'selected' : '' }}>8</option>
            <option value="15" {{ $events->perPage() == 15 ? 'selected' : '' }}>15</option>
            <option value="30" {{ $events->perPage() == 30 ? 'selected' : '' }}>30</option>
            <option value="50" {{ $events->perPage() == 50 ? 'selected' : '' }}>50</option>
        </select>
    </div>
</div>


<div id="events-list" class="events-container">
    @if(count($events) > 0)
        @foreach($events as $event)
            <div class="event-card">
                <div class="event-card-body">
                    <h5 class="event-card-title">{{ $event->name }}</h5>
                    <p class="event-card-text">
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }} <br>
                        <strong>Venue:</strong> {{ $event->venue }} <br>
                        <strong>Available Seats:</strong> {{ $event->available_seat }} <br>
                        <strong>Status:</strong> {{ ucfirst($event->status) }} <br>
                    </p>
                    @if($event->available_seat == 0)
                        <button class="btn btn-primary event-card-button" disabled>Book Ticket</button>
                    @else
                        <a href="#" data-event_id="{{ $event->id }}" class="btn btn-primary event-card-button book_ticket">Book Ticket</a>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="event-card">
            <div class="event-card-body text-center">
                <h5 class="event-card-title">No Event Available</h5>
                <p class="event-card-text">There are no events to display at the moment.</p>
            </div>
        </div>
    @endif
</div>


<!-- Pagination -->
<div id="pagination-container" class="mt-4 d-flex justify-content-end">
    {{ $events->appends(['limit' => request('limit')])->links('pagination::bootstrap-4') }}
</div>



<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Your Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    @csrf
                    <input type="hidden" id="modal_event_id" name="event_id">
                    <div class="form-group">
                        <label for="ticket_holder_name">Ticket Holder Name</label>
                        <input type="text" class="form-control" id="ticket_holder_name" name="booking_name" required oninput="this.value = this.value.replace(/[<>'\"]/g, '')">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Book Ticket</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- AJAX Booking Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('limit').addEventListener('change', function() {
        const limit = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('limit', limit);
        url.searchParams.set('page', 1); // Always reset to page 1 when limit changes
        window.location.href = url.toString();
    });
</script>

<script>

document.getElementById('back-to-booking-page').addEventListener('click', function() {
        window.location.href = "{{ route('booking.home') }}";
    });

$(document).ready(function(){

    // When Book Ticket button is clicked
    $(document).on('click', '.book_ticket', function(e){
        e.preventDefault();
        var eventId = $(this).data('event_id');
        $('#modal_event_id').val(eventId);
        $('#ticket_holder_name').val('');
        $('#bookingModal').modal('show');
    });

    // On form submit
    $('#bookingForm').submit(function(e){
        e.preventDefault();

        var formData = {
            event_id: $('#modal_event_id').val(),
            booking_name: $('#ticket_holder_name').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '{{ route("booking.create") }}',
            method: 'POST',
            data: formData,
            success: function(response){
                if(response.status){
                    $('#bookingModal').modal('hide');
                    showAlert('success', response.message);
                    // Redirect to the booking page
                    setTimeout(function(){
                        window.location.href = '{{ route("booking.home") }}';
                    }, 2000); // Redirect after 2 seconds
                } else {
                    showAlert('alert', response.message);
                }
            },
            error: function(xhr){
                var errorMessage = xhr.responseJSON.message;
                $('#bookingModal').modal('hide');
                showAlert('cancel', errorMessage);
            }
        });
    });

});
</script>

<style>
    .events-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        /* Center the items in the row */
        gap: 20px;
        margin-top: 20px;
    }

    .event-card {
        width: 23%;
        /* Make each card take up 1/4th of the row (25% for 4 cards) */
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .event-card-body {
        padding: 20px;
    }

    .event-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .event-card-text {
        font-size: 0.9rem;
        color: #555;
    }

    .event-card-text strong {
        color: #333;
    }

    .event-card-button {
        margin-top: 15px;
        padding: 10px 20px;
        font-size: 1rem;
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .event-card-button:hover {
        background-color: #0056b3;
        cursor: pointer;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 992px) {
        .event-card {
            width: 48%;
            /* For medium screens, make cards 50% width */
        }
    }

    @media (max-width: 768px) {
        .event-card {
            width: 98%;
            /* For small screens, take up nearly full width */
        }
    }
</style>
