<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\User;


class BookingController extends Controller
{
public function getAllBookings(Request $request)
    {
        check_auth();
        // Fetch booking data
        $bookings = Booking::select('booking_details.*')
            ->join('events', 'booking_details.event_id', '=', 'events.id')
            ->join('users', 'booking_details.user_id', '=', 'users.id')
            ->select('booking_details.*', 'events.name as event_name', 'users.name as user_name', 'events.date as event_date', 'events.venue as event_venue')
            ->where('booking_details.status', 'active')
            ->where('events.status', 'active')
            ->where('users.id', auth()->user()->id)
            ->orderBy('booking_details.created_at', 'desc')
            ->get()
            ->toArray();

        return view('booking.home', compact('bookings'));

    }

    public function getBookingDetails(Request $request, $id)
    {
        check_auth();
        // Fetch booking details by ID
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'booking' => $booking
        ]);
    }

    public function createBooking(Request $request)
    {
        check_auth();
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'booking_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try{
            DB::beginTransaction();
            $event = Event::find($request->input('event_id'));
            if(!$event){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Event not found'
                ], 404);
            }
            $event_avaliable_seat = $event->available_seat;

            if($event_avaliable_seat <= 0){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Event seats are full'
                ], 404);
            }

            $exist_booking = Booking::where('event_id', $request->input('event_id'))
                ->where('user_id', auth()->user()->id)
                ->where('status', 'active')
                ->first();
            if($exist_booking){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'You already have a booking for this event'
                ], 404);
            }


            // Create a new booking
            $booking = Booking::create([
                'event_id' => $request->input('event_id'),
                'user_id' => auth()->user()->id,
                'booking_name' => $request->input('booking_name'),
                'booking_date' => now(),
                'created_by' => auth()->user()->id,
            ]);

            // Update the event's available seats
            $event->available_seat = $event_avaliable_seat - 1;
            $event->save();

            // Update the booking status, after reducing the available seats
            $booking->status = 'active';
            $booking->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Ticket booked successfully',
                'booking' => $booking
            ]);


        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error occurred while creating booking',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function deleteBooking(Request $request, $id)
    {
        check_auth();
        // Fetch booking by ID
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }
        try{
            DB::beginTransaction();
            $event = Event::find($booking->event_id);
            if(!$event){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Event not found'
                ], 404);
            }
            $event_avaliable_seat = $event->available_seat;

            // Update the event's available seats
            $event->available_seat = $event_avaliable_seat + 1;
            $event->save();

            // Delete the booking
            $booking->status = 'deleted';
            $booking->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Booking deleted successfully'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error occurred while deleting booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
