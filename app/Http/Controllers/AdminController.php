<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session as SessionFacade;
use App\Models\Session;
use App\Models\Event;
use App\Models\EventGalleryImage;
use App\Models\EventSlotModel;
use App\Models\Booking;



class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            //print_r(Auth::guard("admin")->attempt(["email" => $request->email,"password" => $request->password,'user_type'=>'1']));die();
            if (Auth::guard("admin")->attempt(["email" => $request->email, "password" => $request->password])) {

                $user = Auth::guard("admin")->user();

                if ($user->user_type != 1) {
                    Auth::guard("admin")->logout();
                    return redirect()->back()->with("warning", "You are not authorized as admin.");
                }
                if ($user->is_deleted == 1) {
                    Auth::guard("admin")->logout();
                    return redirect()->back()->with("warning", "Your account is not activated by administrator.");
                }

                return redirect()->route("admin.dashboard");
            } else {
                echo "Credentails do not matches our record.";
                SessionFacade::flash('message', "Credentails do not matches our record");
                return redirect()->back()->withErros(["email" => "Credentails do not matches our record."]);
            }
        }
        if (Auth::guard("admin")->user()) {
            $user = Auth::guard("admin")->user();

            if ($user->user_type != 1) {
                Auth::guard("admin")->logout();
                return redirect()->route("admin.login")->with("warning", "You are not authorized as admin.");
            }
            return redirect()->route("admin.dashboard");
        } else {
            return view('admin.login');
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function dashboard()
    {
        if (Auth::guard("admin")->user()) {
            $user = Auth::guard("admin")->user();

            if ($user->user_type != 1) {
                Auth::guard("admin")->logout();
                return redirect()->route("admin.login")->with("warning", "You are not authorized as admin.");
            }

            $userCount = \App\Models\User::where('user_status', '=', 1)->count();
            return view('admin.dashboard', compact('userCount'));
        } else {
            return view('admin.login');
        }
    }
    public function getstate(Request $request)
    {
        $state = DB::table('master_state')->where('state_country_id', '=', $request->country_id)->orderBY('state_name', 'asc')->get();
        $data = compact('state');
        return response()->json($data);
    }

    public function getcity(Request $request)
    {
        $city = DB::table('master_city')->where('city_state_id', '=', $request->state_id)->orderBY('city_name', 'asc')->get();
        $data = compact('city');
        return response()->json($data);
    }

    public function getsubType(Request $request)
    {
        $city = DB::table('coach_subtype')->where('coach_type_id', '=', $request->coach_type_id)->orderBY('subtype_name', 'asc')->get();
        $data = compact('city');
        return response()->json($data);
    }

    public function eventList(Request $request)
    {
        $eventlist = DB::table('events')->where('is_deleted', '=', 0)->orderBy('id', 'desc')->paginate(20);

        return view('admin.event-list', compact('eventlist'));
    }
    public function viewEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();
        $eventgallery = DB::table('event_gallery_images')->where('event_id', '=', $id)->get();
        $eventslot = DB::table('event_slot')->where('event_id', '=', $id)->get();

        return view('admin.view-event', compact('eventdetails', 'eventgallery', 'eventslot'));
    }

    public function updateEventStatus(Request $request)
    {
        $user = Event::find($request->user);
        $user->status = $request->status;
        $user->save();
    }

    public function addEvent()
    {
        $eventgallery = collect();
        return view('admin.create-event', compact('eventgallery'));
    }

    public function createEvent(Request $request, $id = null)
    {

        // $user = Auth::user();
        // $user_id = $user->id;

        if ($request->isMethod('post')) {

            $event = Event::find($request->event_id);
            $isUpdate = $event ? true : false;

            if (!$event) {
                $event = new Event();
            }

            $event->user_id = 1;
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
                $eventId = $event->id;

                $startTime = Carbon::parse($request->start_time);
                $endTime   = Carbon::parse($request->end_time);
                $duration  = (int) $request->duration;
                $buffer    = (int) $request->gap;

                $eventDayNames = is_array($request->event_days)
                    ? $request->event_days
                    : json_decode($request->event_days, true);

                $dayNameToNumber = [
                    'Sunday'    => 0,
                    'Monday'    => 1,
                    'Tuesday'   => 2,
                    'Wednesday' => 3,
                    'Thursday'  => 4,
                    'Friday'    => 5,
                    'Saturday'  => 6,
                ];

                $eventDays = [];
                foreach ($eventDayNames as $dayName) {
                    if (isset($dayNameToNumber[$dayName])) {
                        $eventDays[] = $dayNameToNumber[$dayName];
                    }
                }

                $startDate = Carbon::parse($event->start_date);
                $endDate   = Carbon::parse($event->end_date);

                for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

                    if (in_array($date->dayOfWeek, $eventDays)) {
                        $dayStart = $date->copy()->setTimeFrom($startTime);
                        $dayEnd   = $date->copy()->setTimeFrom($endTime);

                        while ($dayStart->copy()->addMinutes($duration)->lte($dayEnd)) {

                            $slotStart = $dayStart->copy();
                            $slotEnd   = $slotStart->copy()->addMinutes($duration);

                            // $exists = EventSlotModel::where('event_id', $eventId)
                            //     ->where('slot_start', $slotStart->format('H:i'))
                            //     ->where('slot_end', $slotEnd->format('H:i'))
                            //     ->exists();

                            //     dd($exists);

                            // if (!$exists) {
                            EventSlotModel::create([
                                'event_id'   => $eventId,
                                'slot_start' => $slotStart->format('H:i'),
                                'slot_end'   => $slotEnd->format('H:i'),
                            ]);
                            //  }

                            $dayStart->addMinutes($duration + $buffer);
                        }
                    }
                }
            }


            return redirect()->route('admin.event-list')->with('success', $isUpdate ? 'Event updated successfully!' : 'Event created successfully!');
        }
    }

    public function editEvent(Request $request)
    {
        $id = $request->id;

        $eventdetails = DB::table('events')->where('id', '=', $id)->where('is_deleted', '=', 0)->first();

        $eventgallery = DB::table('event_gallery_images')->where('event_id', '=', $id)->get();

        // dd($eventgallery);

        return view('admin.create-event', compact('eventdetails', 'eventgallery'));
    }

    public function sessionList(Request $request, $id = null)
    {
        $eventId = $id;
        $sessionlist = DB::table('session')->where('event_id', $eventId)->orderBy('id', 'asc')->paginate(20);

        return view('admin.session-list', compact('sessionlist'));
    }

    public function addSession()
    {
        $events = DB::table('events')->where('is_deleted', '=', 0)->get();

        return view('admin.create-session', compact('events'));
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
        return redirect()->route('admin.session-list', ['id' => $eventId])->with('success', 'Sessions generated successfully!');
    }

    public function edit($id)
    {
        $session = Session::findOrFail($id);

        $event = DB::table('session')->where('id', $session->id)->first();

        $event_id =  $event->event_id;

        return view('admin.create-session', compact('session', 'event_id'));
    }

    public function update(Request $request, $id)
    {
        $eventId = $request->event_id;
        $session = Session::findOrFail($id);
        $session->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.session-list', ['id' => $eventId])->with('success', 'Session updated successfully!');
    }

    public function session_status(Request $request)
    {
        $user = session::find($request->user);
        $user->is_active = $request->is_active;
        $user->save();
    }

    //21-07-2025
    public function bookingList()
    {
        $bookings = Booking::with(['user:id,first_name,last_name', 'event:id,event_name,address', 'slot:id,date,start_time,end_time'])
            ->where('is_active', 1)
            ->whereHas('event', function ($query) {
                $query->where('is_deleted', 0);
            })
            ->whereHas('slot', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();
        // foreach ($bookings as $booking) {
        //     echo "<pre>";
        //     print_r($booking->toArray());
        //     echo "</pre>";
        // }
        return view('admin.bookings_list', compact('bookings'));
    }


    public function viewBooking($id = null)
    {
        $event = Event::where('id', $id)->exists();

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $bookings = Booking::with(['user:id,first_name,last_name', 'event:id,event_name,address', 'slot:id,date,start_time,end_time'])
            ->where('event_id', $id)
            ->get();

        //   dd($bookings);
        if (!$bookings) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        return view('admin.view-booking', compact('bookings'));
    }

    public function slotUserList($slotId=null)
    {
        // dd($slotId);
        $bookings = Booking::with(['user:id,first_name,last_name', 'event:id,event_name', 'slot:id,date,start_time,end_time'])
        ->where('event_slot_id', $slotId)
        ->get();

        // dd($bookings);

        // return view('admin.slot-users');
          return view('admin.slot-users', compact('bookings'));
    }

}
