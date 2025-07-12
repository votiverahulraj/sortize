<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EventGalleryImage;
use Carbon\Carbon;
use App\Models\EventSlotModel;

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
       $eventgallery = collect();
        return view('business.create-event', compact('userCount','eventgallery'));
    }


    public function addEvent(Request $request, $id = null)
{
    $user = Auth::user(); 
    $user_id = $user->id;

    if ($request->isMethod('post')) {

        $event = Event::find($request->event_id);
        $isUpdate = $event ? true : false;

        if (!$event) {
            $event = new Event();
        }

        $event->user_id = $user_id;
        $event->event_name = $request->event_name;
        $event->event_type = (int) $request->event_type;
        $event->date = $request->date;
        $event->address = $request->address;
        $event->lat = $request->lat; 
        $event->long = $request->long; 
        $event->price = (int) $request->price;
        $event->ticket_price = (int) $request->ticket_price;
        $event->ticket_quantity = (int) $request->ticket_quantity;
        $event->event_days = json_encode($request->event_days);
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

        if ($isUpdate) {
            EventSlotModel::where('event_id', $event->id)->delete();
        }

        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $duration = (int) $request->duration;
        $buffer = (int) $request->gap;

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotStart = $start->copy();
            $slotEnd = $start->copy()->addMinutes($duration);

            EventSlotModel::create([
                'event_id' => $event->id,
                'slot_start' => $slotStart->format('H:i'),
                'slot_end' => $slotEnd->format('H:i'),
            ]);

            $start->addMinutes($duration + $buffer);
        }

        if ($request->hasFile('event_media')) {
            if ($isUpdate) {
                EventGalleryImage::where('event_id', $event->id)->delete();
            }

            foreach ($request->file('event_media') as $image) {
                $imageName = 'event_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/event'), $imageName);

                EventGalleryImage::create([
                    'event_id' => $event->id,
                    'event_media' => 'uploads/event/' . $imageName,
                ]);
            }
        }

        return redirect()->route('interprise.event-list')->with('success', $isUpdate ? 'Event updated successfully!' : 'Event created successfully!');
    }
}


    /**
     * Display the specified resource.
     */
   public function eventList(Request $request)
    {
        $user = Auth::user();
        $user_id =  $user->id;
       // dd($user_id);
        $eventlist = DB::table('events')->where('user_id', '=', $user_id)->where('is_deleted', '=', 0)->paginate(20);

        return view('business.event-list', compact('eventlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();

        $eventgallery = DB::table('event_gallery_images')->where('event_id', '=', $id)->get();

       // dd($eventgallery);
       
         return view('business.create-event', compact('eventdetails','eventgallery'));

    }

     public function viewEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        //dd($eventdetails);
         return view('business.view-event', compact('eventdetails'));

    }

   
    public function delete(Request $request)
    {
      
        $user = Event::find($request->event);
        $user->is_deleted = 1;
        $user->save();
    }

}
