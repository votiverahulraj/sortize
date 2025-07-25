<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EventGalleryImage;
use Carbon\Carbon;
use App\Models\EventSlotModel;
use App\Models\Session;
use App\Models\Booking;
use App\Models\EventCategory;
use Illuminate\Support\Facades\DB;

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
        $categories = EventCategory::all();
        $eventgallery = collect();
        return view('business.create-event', compact('userCount', 'eventgallery', 'categories'));
    }


    public function addEvent(Request $request, $id = null)
    {
        $rules = [
            "event_name" => "required|string",
            "event_limit" => "required",
            "event_type" => "required",
            "start_date" => "required|date|after_or_equal:today",
            "end_date" => "required|date|after_or_equal:today",
            "address" => "required",
            "ticket_quantity" => "required|integer|min:1",
            "price" => "required|numeric",
            "start_time" => "required",
            "end_time" => "required",
            "description" => "required",
        ];
        if ($request->event_limit == "1") {
            $rules['event_days'] = "required|array";
            $rules['duration'] = "required";
        }
        $request->validate($rules);

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
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
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

            // if ($request->hasFile('media')) {
            //     $image = $request->file('media');
            //     $imageName = 'event_' . time() . '.' . $image->getClientOriginalExtension();
            //     $image->move(public_path('uploads/event'), $imageName);
            //     $event->media = 'uploads/event/' . $imageName;
            // }

            $event->save();

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

            if ($isUpdate) {
                EventSlotModel::where('event_id', $event->id)->delete();
            }

            if ($event->event_limit == 1) {

                $start = Carbon::parse($request->start_time);
                $end = Carbon::parse($request->end_time);
                $duration = (int) $request->duration;
                $buffer = (int) $request->gap;

                $slots = [];

                while ($start->copy()->addMinutes($duration)->lte($end)) {
                    $slotStart = $start->copy();
                    $slotEnd = $start->copy()->addMinutes($duration);
                    // $slots[] = $current->format('h:i A') . ' – ' . $slotEnd->format('h:i A');
                    // $current->addMinutes($duration + $buffer);
                    // echo "hii";die;

                    EventSlotModel::create([
                        'event_id' => $event->id,
                        'slot_start' => $slotStart->format('H:i'),
                        'slot_end' => $slotEnd->format('H:i'),
                    ]);

                    $start->addMinutes($duration + $buffer);
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
        $eventlist = Event::upcoming()->where('user_id', '=', $user_id)->orderBy('id', 'desc')->paginate(20);

        // dd($eventlist);
        return view('business.event-list', compact('eventlist'));
    }

    public function pastEvents()
    {
        $user = Auth::user();
        $user_id =  $user->id;
        $eventlist = Event::past()->where('user_id', '=', $user_id)->where('is_deleted', '=', 0)->orderBy('id', 'desc')->paginate(20);

        return view('business.event-list', compact('eventlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        $categories = EventCategory::all();
        $eventgallery = DB::table('event_gallery_images')->where('event_id', '=', $id)->get();

        // dd($eventgallery);

        return view('business.create-event', compact('eventdetails', 'eventgallery', 'categories'));
    }

    public function bookingList()
    {
        $user = Auth::user();
        $user_id =  $user->id;

        $bookings = Booking::with(['user:id,first_name,last_name', 'event:id,event_name,address', 'slot:id,date,start_time,end_time'])
            ->where('is_active', 1)
            ->whereHas('event', function ($query) use ($user_id) {
                $query->where('is_deleted', 0)
                    ->where('user_id', $user_id);
            })
            ->whereHas('slot', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();

        // dd($bookings);

        return view('business.booking_list', compact('bookings'));
    }

    public function viewEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        $eventgallery = DB::table('event_gallery_images')->where('event_id', '=', $id)->get();
        $eventslot = DB::table('event_slot')->where('event_id', '=', $id)->get();

        return view('business.view-event', compact('eventdetails', 'eventgallery', 'eventslot'));
    }


    public function delete(Request $request)
    {

        $user = Event::find($request->event);
        $user->is_deleted = 1;
        $user->save();
    }




    public function  sessionList(Request $request, $id = null)
    {
        $eventId = $id;
        $sessionlist = DB::table('session')->where('event_id', $eventId)->orderBy('id', 'asc')->paginate(20);
        //  dd($sessionlist);

        return view('business.session-list', compact('sessionlist'));
    }


    public function generateSessions(Request $request, $id = null)
    {
        $eventId = $id;

        $event = DB::table('events')->where('id', $eventId)->where('is_deleted', 0)->first();

        $eventDayNames = json_decode($event->event_days, true);

        $dayNameToNumber = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
        ];

        $eventDays = [];
        if (empty($eventDayNames)) {
            return redirect()->back()->with('error', 'Event days not provided.');
        }

        foreach ($eventDayNames as $dayName) {
            if (isset($dayNameToNumber[$dayName])) {
                $eventDays[] = $dayNameToNumber[$dayName];
            }
        }

        $buffer = $event->gap;

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $startDate = \Carbon\Carbon::parse($event->start_date);

        $endDate = \Carbon\Carbon::parse($event->end_date);
        //dd($endDate);
        $weekendDates = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (in_array($date->dayOfWeek, $eventDays)) {
                $weekendDates[] = $date->format('Y-m-d');
            }
        }

        $intervalMinutes = !empty($event->duration) ? (int)$event->duration : 120;

        $useCustomTimes = !empty($event->start_time) && !empty($event->end_time);

        $timeSlots = [];

        if ($useCustomTimes) {
            $start = \Carbon\Carbon::createFromFormat('H:i:s', $event->start_time);
            $end = \Carbon\Carbon::createFromFormat('H:i:s', $event->end_time);

            while ($start->lt($end)) {
                $slotStart = $start->copy();
                $slotEnd = $slotStart->copy()->addMinutes($intervalMinutes);

                if ($slotEnd->gt($end)) break;

                $timeSlots[] = [
                    'start' => $slotStart->format('H:i:s'),
                    'end'   => $slotEnd->format('H:i:s'),
                ];

                $start->addMinutes($intervalMinutes + $buffer);
            }
        }

        //     if (!is_array($weekendDates) || !is_array($timeSlots)) {
        //     return redirect()->back()->with('error', 'Invalid data for session creation.');
        // }

        $ticket_quantity = $event->ticket_quantity;
        foreach ($weekendDates as $date) {
            foreach ($timeSlots as $slot) {
                $exists = Session::where('event_id', $eventId)
                    ->where('date', $date)
                    ->where('start_time', $slot['start'])
                    ->where('end_time', $slot['end'])
                    ->exists();

                // if (!$exists) {
                //     Session::create([
                //         'event_id'   => $eventId,
                //         'date'       => $date,
                //         'start_time' => $slot['start'],
                //         'end_time'   => $slot['end'],
                //         'capacity'   => 50,
                //         'is_active'  => 1,
                //         'status'     => 0,
                //     ]);
                // }
                if ($exists) {
                    $session = Session::where('event_id', $eventId)
                        ->where('date', $date)
                        ->where('start_time', $slot['start'])
                        ->where('end_time', $slot['end'])
                        ->first();

                    if ($session) {
                        $session->capacity  = $ticket_quantity;
                        $session->is_active = 1;
                        $session->status    = 0;
                        $session->save();
                    }
                } else {
                    Session::create([
                        'event_id'   => $eventId,
                        'date'       => $date,
                        'start_time' => $slot['start'],
                        'end_time'   => $slot['end'],
                        'capacity'   => $ticket_quantity,
                        'is_active'  => 1,
                        'status'     => 0,
                    ]);
                }
            }
        }
        return redirect()->route('interprise.session-list', ['id' => $eventId])->with('success', 'Sessions generated successfully!');
    }

    public function editSession($id = null)
    {
        try {
            $session = Session::findOrFail($id);
            $event_id = $session->event_id ?? null;
            return view('business.edit-session', compact('session', 'event_id'));
        } catch (\Throwable $th) {
            // dd("error");session-list
            return redirect()->back()->with('error', 'Session not found.');
        }
    }

    public function updateSession(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {

            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $session = Session::findOrFail($id);
            $session->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
            ]);

            return redirect()->route('interprise.session-list', ['id' => $request->event_id])->with('success', 'Session updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update session. Please try again.');
        }
    }

    public function session_status(Request $request)
    {
        $user = session::find($request->user);
        $user->is_active = $request->is_active;
        $user->save();
    }
}
