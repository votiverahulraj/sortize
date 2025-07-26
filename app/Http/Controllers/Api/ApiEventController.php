<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockSlot;
use App\Models\Booking;
use App\Models\Event;
use App\Models\EventCategory;
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

        $getSlots = Session::select('id', 'event_id', 'date', 'start_time', 'end_time', 'capacity' , 'remaining_tickets')
                            ->where('event_id', $request->event_id)
                            ->where('date', $request->event_date)
                            ->where('is_active', 1)
                            //->where('status', 'active')
                            ->get();


        if(!$getSlots){
            return response()->json([
                'status' => 0,
                'message' => 'Slot not available on this date',
            ]);
        }


        $transformedSlots = $getSlots->map(function ($slot) {
            return [
                'id'              => $slot->id,
                'event_id'        => $slot->event_id,
                'date'            => $slot->date,
                'start_time'      => $slot->start_time,
                'end_time'        => $slot->end_time,
                'capacity'        => $slot->capacity,
                'available_ticket'=> $slot->remaining_tickets ?:'', // renamed key
            ];
        });

        return response()->json([
            'status' => 1,
            'message' => 'Available Slots list',
            'data' => $transformedSlots
        ]);
    }



    public function BlockSlot(Request $request)
    {
         Log::info('Block fun is working...');
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



        // ✅ Cleanup expired blocks before proceeding
        $expiredBlocks = BlockSlot::where('event_id', $request->event_id)
            ->where('event_slot_id', $request->event_slot_id)
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expiredBlocks as $expiredBlock) {
            $slot->remaining_tickets += $expiredBlock->quantity;
            $expiredBlock->delete();
        }
        $slot->save();


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
                'expires_at'    => Carbon::now()->addMinutes(1),
            ]);
        });


        return response()->json([
            'status' => 1,
            'message' => 'Tickets temporarily blocked for 10 minutes',
            'data' => [
                'user_id' => $request->user_id,
                'blockSlot_id' => $blockSlot->id ?? '',
                'remaining_tickets' => $slot->remaining_tickets,
            ],
        ]);
    }



    public function BookingEvent(Request $request)
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


    // Check if BlockSlot is expired
    if ($BlockedSlot->expires_at && now()->greaterThan($BlockedSlot->expires_at)) {

        // Refill the remaining_tickets in session table
        $slot = Session::where('event_id', $BlockedSlot->event_id)
                       ->where('id', $BlockedSlot->event_slot_id)
                       ->first();

        if ($slot) {
            $slot->remaining_tickets += $BlockedSlot->quantity;
            $slot->save();
        }

        // Delete the expired block slot
        $BlockedSlot->delete();

        return response()->json([
            'status'  => 0,
            'message' => 'Blocked slot has expired. Please try booking again.',
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





    // public function ClientBookedEventList()
    // {
    //     $response = [
    //         'status' => 0,
    //         'message' => '',
    //         'data' => null
    //     ];

    //     try {
    //        $events = Event::with([
    //                     'coach',
    //                     'joind_members.user',
    //                     'event_reviews',
    //                     'coach.event_reviews',
    //                 ])
    //                 ->where('is_deleted', '0')
    //                 ->where('status', '1')
    //                 ->get();


    //         $eventList = [];

    //         foreach ($events as $event) {
    //             // Get event gallery images
    //             $eventImages = DB::table('event_gallery_images')
    //                 ->where('event_id', $event->id)
    //                 ->pluck('event_media')
    //                 ->map(function ($image) {
    //                     return url('public/' . $image);
    //                 })
    //                 ->toArray();



    //             // Joined members shows
    //             $JoinedMembers = [];

    //             if ($event->joind_members && $event->joind_members->count() > 0) {
    //                 foreach ($event->joind_members as $member) {
    //                     $JoinedMembers[] = [
    //                         'id' => $member->id,
    //                         'user_id' => $member->user_id,
    //                         'event_id' => $member->event_id,
    //                         'first_name' => $member->user->first_name ?? '',
    //                         'last_name' => $member->user->last_name ?? '',
    //                         'profile_image' => $member->user && $member->user->profile_image
    //                                     ? url('public/uploads/profile_image/' . $member->user->profile_image)
    //                                     : '',
    //                     ];
    //                 }
    //             }


    //             // Organizer details show
    //             $coachDetails = $event->coach ? [
    //                 'coach_id' => $event->coach->id,
    //                 'first_name' => $event->coach->first_name ?? '',
    //                 'last_name' => $event->coach->last_name ?? '',
    //                 'contact_number' => $event->coach->contact_number ?? '',
    //                 'profile_image' => $event->coach && $event->coach->profile_image
    //                                     ? url('public/uploads/profile_image/' . $event->coach->profile_image)
    //                                     : '',
    //             ] : '';

    //             // Average rating showing of coach
    //             $coach = $event->coach;
    //             $averageRating = $coach && $coach->event_reviews->count() > 0
    //                     ? round($coach->event_reviews->avg('rating'), 1)
    //                     : null;


    //             // Build the event data
    //             $eventList[] = [
    //                 'event_id'        => $event->id,
    //                 'user_id'         => $event->user_id, // optional if you have many users
    //                 'event_name'      => $event->event_name ?? '',
    //                 'ticket_price'    => $event->ticket_price ?? '',
    //                 'start_date'      => $event->start_date ?? '',
    //                 'end_date'        => $event->end_date ?? '',
    //                 'address'         => $event->address ?? '',
    //                 'start_time'      => $event->start_time ?? '',
    //                 'end_time'        => $event->end_time ?? '',
    //                 //'date_time'     => $event->date_time,
    //                 'event_days'      => json_decode($event->event_days) ?? [],
    //                 'ticket_quantity' => $event->ticket_quantity ?? '',
    //                 'duration'        => $event->duration ?? '',
    //                 'description'     => $event->description ?? '',
    //                 'latitude'        => $event->latitude ?? '',
    //                 'longitude'       => $event->longitude ?? '',
    //                 'event_media'     => $eventImages ?? [],
    //                 'organizer'       => $coachDetails ?? '',
    //                 'review_avg_rating' => $averageRating ? number_format($averageRating, 2) : '',
    //                 'event_reviews' => $event->event_reviews->map(function ($review) {
    //                     return [
    //                         'review_id' => $review->id ?? '',
    //                         'user_id'   => $review->user_id ?? '',
    //                         'user_name' => optional($review->user)->first_name . ' ' . optional($review->user)->last_name ?? '',
    //                         'profile_image' => $review->user && $review->user->profile_image
    //                             ? url('public/uploads/profile_image/' . $review->user->profile_image)
    //                             : '',
    //                         'rating'    => $review->rating ?? '',
    //                         'comment'   => $review->comment ?? '',
    //                         'created_at'=> $review->created_at->format('Y-m-d H:i:s') ?? '',
    //                     ];
    //                 }),
    //                 'joined_members' => $JoinedMembers,
    //                 'joined_members_count' => count($JoinedMembers),
    //                 'commission_price' => "10"
    //             ];
    //         }

    //         // Final response
    //         $response['status'] = 1;
    //         $response['message'] = 'Event listing';
    //         $response['data'] = ['event_listing' => $eventList];

    //     } catch (\Exception $e) {
    //         $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    //     }

    //     return response()->json($response);
    // }


    public function UserBookedEventList(Request $request)
    {
        $response = [
            'status' => 0,
            'message' => '',
            'data' => null
        ];

        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'event_type' => 'required|string|in:past,upcoming',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user_id = $request->user_id; // assuming auth is being used
            $event_type = $request->event_type; //

            // Get booked event IDs from bookings table for this user
            $bookings = Booking::with('slot')
                ->where('user_id', $user_id)
                ->where('booking_status', 'completed')
                ->where('payment_status', 'success')
                ->get();

            // Group bookings by event_id for easier access later
            $bookingsGrouped = $bookings->groupBy('event_id');

            // Extract unique event IDs
            $bookedEventIds = $bookings->pluck('event_id')->unique()->toArray();

            //return $bookedEventIds;
            // Get events based on those IDs
            $events = Event::with([
                            'coach',
                            'joind_members.user',
                            'event_reviews',
                            'coach.event_reviews',
                        ])
                        ->whereIn('id', $bookedEventIds)
                        //->where('is_deleted', '0')
                        //->where('status', '1')
                        ->get();

            $EventList = [];
            foreach ($events as $event) {


                $BookingDetails = [];

                foreach ($bookings as $booking) {
                    if ($booking->event_id == $event->id && $booking->slot) {
                        $BookingDetails[] = [
                            'booking_id'      => $booking->id,
                            'slot_id'         => $booking->event_slot_id,
                            'ticket_quantity' => $booking->ticket_quantity,
                            'total_price'     => $booking->total_price,
                            'payment_method'  => $booking->payment_method,
                            'payment_status'  => $booking->payment_status,
                            'booking_status'  => $booking->booking_status,
                            'booked_at'       => $booking->booked_at,
                        ];
                    }
                }

                // Get bookings for this event
                $eventBookings = $bookingsGrouped[$event->id] ?? collect();
                $slotDetails = [];

                foreach ($eventBookings as $booking) {
                    if ($booking->slot) {
                        $slotDetails[] = [
                            'event_slot_id' => $booking->slot->id,
                            'date'          => $booking->slot->date ?? '',
                            'start_time'    => $booking->slot->start_time ?? '',
                            'end_time'      => $booking->slot->end_time ?? '',
                            // Add other slot fields as needed
                        ];
                    }
                }


                // Event gallery images
                $eventImages = DB::table('event_gallery_images')
                    ->where('event_id', $event->id)
                    ->pluck('event_media')
                    ->map(fn($image) => url('public/' . $image))
                    ->toArray();

                $JoinedMembers = [];

                if ($event->joind_members && $event->joind_members->count() > 0) {
                    foreach ($event->joind_members as $member) {
                        $JoinedMembers[] = [
                            'id' => $member->id,
                            'user_id' => $member->user_id,
                            'event_id' => $member->event_id,
                            'first_name' => $member->user->first_name ?? '',
                            'last_name' => $member->user->last_name ?? '',
                            'profile_image' => $member->user && $member->user->profile_image
                                            ? url('public/uploads/profile_image/' . $member->user->profile_image)
                                            : '',
                        ];
                    }
                }

                $coachDetails = $event->coach ? [
                    'coach_id' => $event->coach->id,
                    'first_name' => $event->coach->first_name ?? '',
                    'last_name' => $event->coach->last_name ?? '',
                    'contact_number' => $event->coach->contact_number ?? '',
                    'profile_image' => $event->coach && $event->coach->profile_image
                                        ? url('public/uploads/profile_image/' . $event->coach->profile_image)
                                        : '',
                ] : '';

                $averageRating = $event->coach && $event->coach->event_reviews->count() > 0
                    ? round($event->coach->event_reviews->avg('rating'), 1)
                    : null;


                $now = now();

                if ($event_type === 'past' && $event->end_date <= $now) {
                    $EventList[] = [
                        'event_id'        => $event->id,
                        'user_id'         => $event->user_id,
                        'event_name'      => $event->event_name ?? '',
                        'ticket_price'    => $event->ticket_price ?? '',
                        'start_date'      => $event->start_date ?? '',
                        'end_date'        => $event->end_date ?? '',
                        'address'         => $event->address ?? '',
                        'event_days'      => json_decode($event->event_days) ?? [],
                        'description'     => $event->description ?? '',
                        'latitude'        => $event->latitude ?? '',
                        'longitude'       => $event->longitude ?? '',
                        'event_media'     => $eventImages,
                        'organizer'       => $coachDetails,
                        'organizer_avg_rating' => $averageRating ? number_format($averageRating, 2) : '',
                        'booking_details' => $BookingDetails,
                        'slot_details'    => $slotDetails,
                        'event_reviews'   => $event->event_reviews->map(function ($review) {
                            return [
                                'review_id' => $review->id ?? '',
                                'user_id'   => $review->user_id ?? '',
                                'user_name' => optional($review->user)->first_name . ' ' . optional($review->user)->last_name ?? '',
                                'profile_image' => $review->user && $review->user->profile_image
                                    ? url('public/uploads/profile_image/' . $review->user->profile_image)
                                    : '',
                                'rating'    => $review->rating ?? '',
                                'comment'   => $review->comment ?? '',
                                'created_at'=> $review->created_at->format('Y-m-d H:i:s') ?? '',
                            ];
                        }),
                        'joined_members' => $JoinedMembers,
                        'joined_members_count' => count($JoinedMembers),
                        'commission_price' => "10"
                    ];
                } elseif ($event_type === 'upcoming' && $event->end_date > $now) {
                    $EventList[] = [
                        'event_id'        => $event->id,
                        'user_id'         => $event->user_id,
                        'event_name'      => $event->event_name ?? '',
                        'ticket_price'    => $event->ticket_price ?? '',
                        'start_date'      => $event->start_date ?? '',
                        'end_date'        => $event->end_date ?? '',
                        'address'         => $event->address ?? '',
                        'event_days'      => json_decode($event->event_days) ?? [],
                        'description'     => $event->description ?? '',
                        'latitude'        => $event->latitude ?? '',
                        'longitude'       => $event->longitude ?? '',
                        'event_media'     => $eventImages,
                        'organizer'       => $coachDetails,
                        'organizer_avg_rating' => $averageRating ? number_format($averageRating, 2) : '',
                        'booking_details' => $BookingDetails,
                        'slot_details'    => $slotDetails,
                        'event_reviews'   => $event->event_reviews->map(function ($review) {
                            return [
                                'review_id' => $review->id ?? '',
                                'user_id'   => $review->user_id ?? '',
                                'user_name' => optional($review->user)->first_name . ' ' . optional($review->user)->last_name ?? '',
                                'profile_image' => $review->user && $review->user->profile_image
                                    ? url('public/uploads/profile_image/' . $review->user->profile_image)
                                    : '',
                                'rating'    => $review->rating ?? '',
                                'comment'   => $review->comment ?? '',
                                'created_at'=> $review->created_at->format('Y-m-d H:i:s') ?? '',
                            ];
                        }),
                        'joined_members' => $JoinedMembers,
                        'joined_members_count' => count($JoinedMembers),
                        'commission_price' => "10"
                    ];
                }

            }

            $response['status'] = 1;
            $response['message'] = 'Booked upcoming & past events list';
            $response['data'] = ['event_listing' => $EventList];

        } catch (\Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }

        return response()->json($response);
    }


    public function EventListFilters(Request $request)
    {
        $response = [
            'status' => 0,
            'message' => '',
            'data' => null
        ];

        try {





        $validator = Validator::make($request->all(), [
            'category_id'    => 'nullable|integer',
            'days'           => 'nullable|string|in:today,tomorrow,week', //  "today", "tomorrow", "week"
            'from_date'      => 'nullable|date',
            'location'       => 'nullable|array|size:2', // latitude , longitude
            'price_range'    => 'nullable|array|size:2', // 0 to max
            'event_title'    => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $category_id = 1; // category
        $days = $request->days; // days
        $from_date = $request->from_date; //
        $location = $request->location; // country
        $price_range = $request->price_range; // country
        $event_title = $request->event_title; // country



        $events = Event::with([
                    'coach',
                    'event_slots',
                    'joind_members.user',
                    'event_reviews',
                    'coach.event_reviews',
                ])
                ->where('is_deleted', '0')
                ->where('status', '1')

                ->when($category_id, fn($q) =>
                    $q->where('event_type', $category_id))
                ->get();





            $eventList = [];

            foreach ($events as $event) {
                // Get event gallery images
                $eventImages = DB::table('event_gallery_images')
                    ->where('event_id', $event->id)
                    ->pluck('event_media')
                    ->map(function ($image) {
                        return url('public/' . $image);
                    })
                    ->toArray();

                // Events slots shows
                $EventSlots = [];
                if ($event->event_slots && $event->event_slots->count() > 0) {
                    foreach ($event->event_slots as $slot) {
                        $EventSlots[] = [
                            'id' => $slot->id,
                            'event_id' => $slot->event_id,
                            'slot_start' => $slot->slot_start,
                            'slot_end' => $slot->slot_end,
                        ];
                    }
                }

                // Joined members shows
                $JoinedMembers = [];

                if ($event->joind_members && $event->joind_members->count() > 0) {
                    foreach ($event->joind_members as $member) {
                        $JoinedMembers[] = [
                            'id' => $member->id,
                            'user_id' => $member->user_id,
                            'event_id' => $member->event_id,
                            'first_name' => $member->user->first_name ?? '',
                            'last_name' => $member->user->last_name ?? '',
                            'profile_image' => $member->user && $member->user->profile_image
                                        ? url('public/uploads/profile_image/' . $member->user->profile_image)
                                        : '',
                        ];
                    }
                }


                // Organizer details show
                $coachDetails = $event->coach ? [
                    'coach_id' => $event->coach->id,
                    'first_name' => $event->coach->first_name ?? '',
                    'last_name' => $event->coach->last_name ?? '',
                    'contact_number' => $event->coach->contact_number ?? '',
                    'profile_image' => $event->coach && $event->coach->profile_image
                                        ? url('public/uploads/profile_image/' . $event->coach->profile_image)
                                        : '',
                ] : '';

                // Average rating showing of coach
                $coach = $event->coach;
                $averageRating = $coach && $coach->event_reviews->count() > 0
                        ? round($coach->event_reviews->avg('rating'), 1)
                        : null;


                // Build the event data
                $eventList[] = [
                    'event_id'        => $event->id,
                    'user_id'         => $event->user_id, // optional if you have many users
                    'event_name'      => $event->event_name ?? '',
                    'ticket_price'    => $event->ticket_price ?? '',
                    'price'           => $event->price ?? '',
                    'start_date'      => $event->start_date ?? '',
                    'end_date'        => $event->end_date ?? '',
                    'address'         => $event->address ?? '',
                    'start_time'      => $event->start_time ?? '',
                    'end_time'        => $event->end_time ?? '',
                    //'date_time'     => $event->date_time,
                    'event_days'      => json_decode($event->event_days) ?? [],
                    'ticket_quantity' => $event->ticket_quantity ?? '',
                    'duration'        => $event->duration ?? '',
                    'description'     => $event->description ?? '',
                    'latitude'        => $event->lat ?? '',
                    'longitude'       => $event->long ?? '',
                    'event_media'     => $eventImages ?? [],
                    'organizer'       => $coachDetails ?? '',
                    'review_avg_rating' => $averageRating ? number_format($averageRating, 2) : '',
                    'event_reviews' => $event->event_reviews->map(function ($review) {
                        return [
                            'review_id' => $review->id ?? '',
                            'user_id'   => $review->user_id ?? '',
                            'user_name' => optional($review->user)->first_name . ' ' . optional($review->user)->last_name ?? '',
                            'profile_image' => $review->user && $review->user->profile_image
                                ? url('public/uploads/profile_image/' . $review->user->profile_image)
                                : '',
                            'rating'    => $review->rating ?? '',
                            'comment'   => $review->comment ?? '',
                            'created_at'=> $review->created_at->format('Y-m-d H:i:s') ?? '',
                        ];
                    }),
                    'event_slots' => $EventSlots,
                    'joined_members' => $JoinedMembers,
                    'joined_members_count' => count($JoinedMembers),
                    'commission_price' => "10"
                ];
            }





            $event_categories = EventCategory::get();
            $event_highest_ticket_price = Event::max('ticket_price');


            // Final response
            $response['status'] = 1;
            $response['message'] = 'Event listing';
            $response['data'] = [
                'filters' => [
                    'event_highest_ticket_price' => $event_highest_ticket_price,
                    'event_categories' => $event_categories,
                ],
                'event_listing' => $eventList
            ];

        } catch (\Exception $e) {
            $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
        }

        return response()->json($response);
    }



}
