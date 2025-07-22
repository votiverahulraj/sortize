<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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


    public function slotBooking()
    {

        return view('admin.booking_slot');
    }


    public function viewBooking($id=null)
    {
        $bookingId=$id;

        $bookingInfo = Booking::with([
                'user:id,first_name,last_name,email,contact_number,gender,country_id',
                'user.country:country_id,country_name',
                'user.state:state_id,state_name',
                'user.city:city_id,city_name',
                'event:id,event_name,address,start_date,end_date,event_days,description',
                'slot:id,date,start_time,end_time'
            ])
            ->where('id',  $bookingId)
            ->first();
        //  dd($bookingInfo);


        if (!$bookingInfo) {
            return redirect()->back()->with('error', 'Booking not found.');
        }


         return view('business.view_booking',compact('bookingInfo'));

    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
