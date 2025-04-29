<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EventController extends Controller
{
    public function index(Request $request)
    {

        check_auth();
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 8);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $events = Event::where('status', 'active')->where('date', '>=', now())->orderBy('date', 'asc')->paginate($limit);

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return only the updated events and pagination HTML
            return response()->json([
                'status' => true,
                'events' => view('event._events', compact('events'))->render(),
                'pagination' => $events->links('pagination::bootstrap-4')->render(),
            ]);
        }
        // Fetch events with pagination
        return view('event.home', compact('events'));
    }

}
