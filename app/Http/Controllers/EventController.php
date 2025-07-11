<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function createEvent(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();
        return view('business.create-event', compact('userCount'));
    }

    public function addEvent(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {
            $event = Event::find($request->event_id);
            if (!$event) {
                $event = new Event();
            }
     
    $media = null;
    $event->event_name = $request->event_name;
    $event->event_type = (int) $request->event_type;
    $event->date = $request->date;
    $event->address = $request->address;
    $event->price = (int) $request->price;
    $event->ticket_price = (int) $request->ticket_price;
    $event->ticket_quantity = (int) $request->ticket_quantity;
    $event->event_days = json_encode($request->event_days); // array to JSON
    $event->start_time = $request->start_time;
    $event->end_time = $request->end_time;
    $event->duration = $request->duration;
    $event->gap = $request->gap;
    $event->event_limit = (int) $request->event_limit;
    $event->description = $request->description;
    $event->date_time = $request->date_time;
    $event->is_deleted = 0;
    $event->status = 0;

     if ($request->hasFile('media')) {
        $image = $request->file('media');
        $imageName = 'event_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/event'), $imageName);
        $event->media = 'uploads/event/' . $imageName;
    }

    $event->save();

    return redirect()->route('interprise.event-list')->with('success', 'Event created successfully!');

    }
}

    /**
     * Display the specified resource.
     */
   public function eventList(Request $request)
    {
        $eventlist = DB::table('events')->where('is_deleted', '=', 0)->paginate(20);

        return view('business.event-list', compact('eventlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        //dd($eventdetails);
         return view('business.create-event', compact('eventdetails'));

    }

   
    public function delete(Request $request)
    {
      
        $user = Event::find($request->event);
        $user->is_deleted = 1;
        $user->save();
    }

}
