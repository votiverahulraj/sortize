<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockSlot;
use App\Models\Booking;
use App\Models\Event;
use App\Models\EventGalleryImage;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiEventController extends Controller
{


    public function EventSlotbyDate(Request $request) {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|integer',
            'event_date' => 'required|date', // better to validate as 'date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        $getSlots = Session::select('id', 'event_id', 'date', 'start_time', 'end_time', 'capacity')
                            ->where('event_id', $request->event_id)
                            ->where('date', $request->event_date)
                            ->where('is_active', 1)
                            ->where('status', 'active')
                            ->get()
                            ->map(function ($slot) {
                                $slot->available_ticket = 23; // Add custom key-value
                                return $slot;
                            });

        if(!$getSlots){
            return response()->json([
                'status' => 1,
                'message' => 'Not Available Slots',
            ]);
        }
        return response()->json([
            'status' => 1,
            'message' => 'Available Slots list',
            'data' => $getSlots
        ]);
    }



    public function BlockSlot(Request $request)
    {
        // Log::info('Block fun is working...');
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'event_id' => 'required|integer',
            'event_slot_id' => 'required|integer',
            'quantity' => 'required|integer|max:500',
            'total_price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the session
        $slot = Session::where('event_id', $request->event_id)
                        ->where('id', $request->event_slot_id)
                        ->first();

        if (!$slot) {
            return response()->json([
                'status' => 0,
                'message' => 'Slot not found',
            ]);
        }

        // Initialize remaining_tickets from capacity if null
        if (is_null($slot->remaining_tickets)) {
            $slot->remaining_tickets = $slot->capacity;
        }

        // Check availability
        if ($slot->remaining_tickets < $request->quantity) {
            return response()->json([
                'status' => 0,
                'message' => 'Not enough tickets available',
            ]);
        }

        // // Check if the slot is already blocked (expires_at > now())
        // $existingBlockedSlot = BlockSlot::where('event_id', $request->event_id)
        //                                 ->where('event_slot_id', $request->event_slot_id)
        //                                 ->where('expires_at', '>', now())
        //                                 ->first();

        // if ($existingBlockedSlot) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => 'This slot is already blocked, please wait until it expires',
        //     ]);
        // }

        $blockSlot = null; // Declare outside

        DB::transaction(function () use ($slot, $request, &$blockSlot) {
            $slot->remaining_tickets -= $request->quantity;
            $slot->save();

            // Assign to the outer variable by reference
            $blockSlot = BlockSlot::create([
                'user_id'       => $request->user_id,
                'event_slot_id' => $slot->id,
                'event_id'      => $slot->event_id,
                'quantity'      => $request->quantity,
                'total_price'   => $request->total_price,
                'expires_at'    => Carbon::now()->addMinutes(10),
            ]);
        });


        return response()->json([
            'status' => 1,
            'message' => 'Tickets temporarily blocked for 10 minutes',
            'data' => [
                'user_id' => $request->user_id,
                'blockSlot_id' => $blockSlot->id ?? null,
                'remaining_tickets' => $slot->remaining_tickets,
            ],
        ]);
    }



    public function BookingSlot(Request $request)
    {
        // Log::info('Block fun is working...');
        $validator = Validator::make($request->all(), [
            'Blockslot_id' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the session
        $BlockedSlot = BlockSlot::where('id', $request->Blockslot_id)
                        ->first();

        if (!$BlockedSlot) {
            return response()->json([
                'status' => 0,
                'message' => 'Block Slot deleted or invailid',
            ]);
        }

        //   return $BlockedSlot;

            $bookingData = Booking::create([
                'user_id'         => $BlockedSlot->user_id,
                'event_id'        => $BlockedSlot->event_id,
                'event_slot_id'   => $BlockedSlot->event_slot_id, // ✅ Fix here
                'ticket_quantity' => $BlockedSlot->quantity,
                'total_price'     => $BlockedSlot->total_price,
                'payment_status'  => "success",
                'payment_method'  => $request->payment_method,
                'booking_status'  => "completed",
                'booked_at'       => now(), // ✅ optional if you want to log timestamp
                'is_active'       => 1       // ✅ optional if your table needs this
            ]);


            // Delete block slot colenm from blockslot table
            $BlockedSlot->delete();


            return response()->json([
                'status'    => 1,
                'message'   => 'Booked successfully',
                'data'      => $bookingData,
            ]);


    }




}
