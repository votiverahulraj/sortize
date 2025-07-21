<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiEventController extends Controller
{
    public function EventSlotbyDate(Request $request) {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|integer|max:255',
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
                'data' => $getSlots
            ]);
        }
        return response()->json([
            'status' => 1,
            'message' => 'Available Slots list',
            'data' => $getSlots
        ]);
    }
}
