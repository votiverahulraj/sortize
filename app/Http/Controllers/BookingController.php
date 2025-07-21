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
            ->whereHas('event', function($query)use ($user_id) {
                $query->where('is_deleted', 0)
                ->where('user_id',$user_id);
            })
            ->whereHas('slot', function($query) {
                $query->where('is_active', 1);
            })
            ->get();

        return view('business.booking_list', compact('bookings'));
    }


    public function slotBooking()
    {

        return view('admin.booking_slot');
    }

    /**
     * Store a newly created resource in storage.
     */
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
