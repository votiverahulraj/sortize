<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Otp;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

// bdfhdfhd

class UserController extends Controller
{


public function register(Request $request)
{
    // echo "<pre>";print_r($request->all());die;
    $response = [
        'status' => 0,
        'message' => '',
    ];

    $data_post = [
        'first_name' => $request->input('first_name', ''),
        'last_name' => $request->input('last_name', ''),
        'email' => $request->input('email', ''),
        'password' => $request->input('password', ''),
        'user_type' => $request->input('user_type', ''),
        'user_age' => $request->input('user_age', ''),
        'professional_title' => $request->input('professional_title', ''),
        'deviceid' => $request->input('deviceid', ''),
        'devicetype' => $request->input('devicetype', ''),
    ];

    // Validate inputs
    if (empty($data_post['first_name'])) {
        $response['errorcode'] = "40001";
        $response['message'] = "First Name: Required parameter missing";
    } elseif (empty($data_post['last_name'])) {
        $response['errorcode'] = "40003";
        $response['message'] = "Last Name: Required parameter missing";
    }elseif (empty($data_post['user_type'])) {
        $response['errorcode'] = "40003";
        $response['message'] = "User Type: Required parameter missing";
    }elseif (empty($data_post['email'])) {
        $response['errorcode'] = "40002";
        $response['message'] = "Email ID: Required parameter missing";
    } elseif (empty($data_post['password'])) {
        $response['errorcode'] = "40003";
        $response['message'] = "Password: Required parameter missing";
    } elseif (empty($data_post['user_age'])) {
        $response['errorcode'] = "40003";
        $response['message'] = "User Age: Required parameter missing";
    } elseif (empty($data_post['professional_title'])) {
        $response['errorcode'] = "40003";
        $response['message'] = "Professional Title: Required parameter missing";
    } elseif (empty($data_post['deviceid'])) {
        $response['errorcode'] = "40005";
        $response['message'] = "Device ID: Required parameter missing";
    } elseif (empty($data_post['devicetype'])) {
        $response['errorcode'] = "40006";
        $response['message'] = "Device Type: Required parameter missing";
    } else {
        try {
            // Check for duplicate email
            if (User::where('email', $data_post['email'])->where('is_deleted', 0)->exists()) {
                $response['errorcode'] = "40007";
                $response['message'] = "The email ID is already registered.";
            } else {
                // Generate token for email verification
                $verification_token = Str::random(64);

                // echo $verification_token;die;
                // Create user

                if ($request->hasFile('certificate')) {
                    $image = $request->file('certificate');
                    $imageName = "stu" . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/uploads/student_certificate'), $imageName);
                }
                $user = User::create([
                    'first_name' => $data_post['first_name'],
                    'last_name' => $data_post['last_name'],
                    'email' => $data_post['email'],
                    'password' => Hash::make($data_post['password']),
                    'user_age' => $data_post['user_age'],
                    'professional_title' => $data_post['professional_title'],
                    'device_id' => $data_post['deviceid'],
                    'student_certificate' => $imageName,
                    'device_type' => $data_post['devicetype'],
                    'user_status' => 0,
                    'is_deleted' => 0,
                    'is_paid' => 0,
                    'user_type' => $data_post['user_type'],
                    'email_verified' => 0,
                    'email_verification_token' => $verification_token, // You need this column in users table
                ]);

                // Generate personal access token
                $token = $user->createToken($data_post['email'])->plainTextToken;

                // Prepare data for email
                $full_url = url('/api/changeStatus') . '?user_id=' . $user->id . '&token=' . $verification_token;

                $emailData = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'user_id' => $user->id,
                    'full_url' => $full_url,
                ];

                // Send email
                Mail::send('emails.verify_signup', $emailData, function ($message) use ($user) {
                    $message->to($user->email)->subject('Verify Your Email');
                });

                // Return response
                $response['status'] = 1;
                $response['message'] = "User registered successfully. Please verify your email.";
                $response['data'] = [
                    'token' => $token,
                    'user_detail' => $user
                ];
            }
        } catch (\Exception $e) {
            $response['errorcode'] = "50001";
            $response['message'] = "An unexpected error occurred: " . $e->getMessage();
        }
    }

    return response()->json($response);
}

public function verifyEmail(Request $request)
{
    $user_id = $request->input('user_id');
    $token = $request->input('token');

    $user = User::where('id', $user_id)
                ->where('email_verification_token', $token)
                ->first();

    if ($user) {
        $user->email_verified = 1;
        $user->email_verification_token = null;
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => 'Email successfully verified.',
        ]);
    } else {
        return response()->json([
            'status' => 0,
            'message' => 'Invalid or expired verification link.',
        ]);
    }
}

public function login(Request $request)
{
    // echo "test";die;
    $response = [
        'status' => 0,
        'message' => '',
    ];

    $email = $request->input('email', '');
    $password = $request->input('password', '');
    $deviceid = $request->input('deviceid', '');
    $devicetype = $request->input('devicetype', '');

    // Validate required inputs
    if (empty($email)) {
        $response['errorcode'] = "40001";
        $response['message'] = "Email is required.";
    } elseif (empty($password)) {
        $response['errorcode'] = "40002";
        $response['message'] = "Password is required.";
    } elseif (empty($deviceid)) {
        $response['errorcode'] = "40003";
        $response['message'] = "Device ID is required.";
    } elseif (empty($devicetype)) {
        $response['errorcode'] = "40004";
        $response['message'] = "Device Type is required.";
    } else {
        try {
            $user = User::where('email', $email)->where('is_deleted', 0)->first();

            if (!$user) {
                $response['errorcode'] = "40005";
                $response['message'] = "Invalid email or password.";
            } elseif (!Hash::check($password, $user->password)) {
                $response['errorcode'] = "40006";
                $response['message'] = "Invalid email or password.";
            } elseif ($user->email_verified == 0) {
                $response['errorcode'] = "40007";
                $response['message'] = "Please verify your email address before logging in.";
            } else {
                // Update device info if needed
                $user->update([
                    'device_id' => $deviceid,
                    'device_type' => $devicetype,
                ]);

                // Create token
                $token = $user->createToken($email)->plainTextToken;

                $response['status'] = 1;
                $response['message'] = "Login successful.";
                $response['data'] = [
                    'token' => $token,
                    'user_detail' => $user
                ];
            }
        } catch (\Exception $e) {
            $response['errorcode'] = "50001";
            $response['message'] = "An unexpected error occurred: " . $e->getMessage();
        }
    }

    return response()->json($response);
}

public function forget_pwd(Request $request)
{
    // echo "testfor";die;
    // Initialize response structure
    $response = [
        'status' => 0,
        'message' => '',
        'data' => []
    ];

    // Validate input


    try {
        $request->validate([
            'email' => 'required|email',
            'user_type' => 'required',
        ], [
            'email.required' => 'Email ID is required',
            'user_type.required' => 'User Type is required',
            'email.email' => 'Please provide a valid email address',
        ]);

        $emailId = trim($request->input('email'));
        // Check if the user exists
        $user = DB::table('users')->where('email', $emailId)->first();

        if ($user) {
            if ($user->email_verified ==  1) {
                // Generate OTP
                $otpCode = rand(1000, 9999);

                // Store OTP details
                $otpData = Otp::create([
                    'user_id' => $user->id,
                    'user_type' => $request->user_type,
                    'otp_type' => "1",
                    'otp_code' => $otpCode,
                    'is_verify' => "0",
                ]);

                $emailData = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'otp' => $otpCode,

                ];
                Mail::send('emails.forgot_pwd', $emailData, function ($message) use ($emailId) {
                    $message->to($emailId)
                        ->subject('Forgot Password');
                });


                // Prepare success response
                $response['status'] = 1;
                $response['message'] = "OTP has been sent to your email. Please verify it.";
                $response['data'] = [
                    'user_detail' => $user,
                    'otp_detail' => $otpData,
                ];
            } else {
                $response['status'] = 2;
                $response['errorcode'] = "50002";
                $response['message'] = "Sorry, your account is not active. Please verify your email ID via OTP.";
            }
        } else {
            $response['status'] = 0;
            $response['errorcode'] = "50003";
            $response['message'] = "The email ID is not registered with us. First Registered.";
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        $response['status'] = 0;
        $response['message'] = $e->validator->errors()->first();
    } catch (\Exception $e) {
        // Handle exceptions
        $response['status'] = 0;
        $response['errorcode'] = "50004";
        $response['message'] = "An error occurred: " . $e->getMessage();
    }

    // Return JSON response
    return response()->json($response);
}

public function verify_OTP(Request $request)
{
    // echo "test";die;
    $response = [
        'status' => 0,
        'message' => '',
        'data' => []
    ];


    // Collect input data
    $data_post = [
        'email' => $request->input('email', ''),
        'otp' => $request->input('otp', ''),
        // 'from' => $request->input('from', '')
    ];

    // Validate input data
    if (empty($data_post['email'])) {
        $response['errorcode'] = "20001";
        $response['message'] = "Email Id: Required parameter missing";
    } elseif (empty($data_post['otp'])) {
        $response['errorcode'] = "20002";
        $response['message'] = "Otp: Required parameter missing";
    }
    // elseif (empty($data_post['from'])) {
    //     $response['errorcode'] = "20003";
    //     $response['message'] = "From: Required parameter missing";
    // }
     else {

        try {

            $vefifyuser = User::where('email',$request->email)->first();

            // print_r($userdetail->id);die;

            if (!$vefifyuser) {
                $response['errorcode'] = "20005";
                $response['message'] = "Invalid Email Id.";
                return response()->json($response);
            }

            $verifyDetail = Otp::where('user_id',$vefifyuser->id)->where('is_verify',0)->first();

    // print_r($verifyDetail);die;


            if ($verifyDetail && $verifyDetail->is_verify == 1) {
                $response['errorcode'] = "20005";
                $response['message'] = "Your Otp has been expired.";
                return response()->json($response);
            }

          if($request->from == "2" ){
            $otpDetail = Otp::where('user_id',$vefifyuser->id)->where('is_verify',0)->where('otp_code',$request->otp)->first();


            // if ( $vefifyuser->user_status == 1) {
            //     $response['errorcode'] = "20005";
            //     $response['message'] = "You have already registered.";
            //     return response()->json($response);
            // }

            if ($otpDetail && $otpDetail->is_verify == 1) {
                $response['errorcode'] = "20005";
                $response['message'] = "You have already used this OTP.";
                return response()->json($response);
            }

            // print_r($otpDetail);die;
         if($otpDetail){
            $userdetial = User::where('id',$otpDetail->user_id)->first();

            // print_r($userdetial);die;
            $userdetial->user_status = 1;
            $userdetial->save();

            $otpDetail->is_verify = 1;
            $otpDetail->save();

            $response['status'] = 1;
            $response['message'] = "Sign Up: Success";
            $response['data'] = ['user_detail' => $userdetial ];
         }else{
            $response['errorcode'] = "20005";
            $response['message'] = "Invalid OTP. Please enter a valid OTP.";
         }


        } else{
           //Forgot password form = 1
           $otpDetail = Otp::where('user_id',$vefifyuser->id)->where('otp_code',$request->otp)->where('is_verify',0)->first();
         if($otpDetail){

            $userdetial = User::where('id',$otpDetail->user_id)->first();

            // $otpDetail->is_verify = 1;
            $otpDetail->delete();

            $response['status'] = 1;
            $response['message'] = "Verify OTP successfully";
            $response['data'] = array('user_detail'=>array($userdetial));
         }else{
            $response['errorcode'] = "20005";
            $response['message'] = "Invalid OTP. Please enter a valid OTP.";
         }
        }
        } catch (\Exception $e) {
            $response['errorcode'] = "50001";
            $response['message'] = "An unexpected error occurred: " . $e->getMessage();
        }
    }


    return response()->json($response);
}

public function resetPassword(Request $request)
{
    // echo "test";die;
    // Initialize response structure
    $response = [
        'status' => 0,
        'message' => '',
        'data' => []
    ];

    try {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'newpassword' => 'required|min:6',
        ], [
            'email.required' => 'User ID is required.',
            'email.email' => 'Please provide a valid email address.',
            'newpassword.required' => 'New password is required.',
            'newpassword.min' => 'New password must be at least 6 characters.',
        ]);

        $userId = trim($request->input('email'));
        $newPassword = trim($request->input('newpassword'));

        // Check if the user exists
        $user = DB::table('users')->where('email', $userId)->first();

        if ($user) {
            // Update password
            DB::table('users')
                ->where('email', $userId)
                ->update([
                    'password' => Hash::make($newPassword), // Securely hash password
                ]);

            // Fetch updated user data
            $userData = DB::table('users')->where('email', $userId)->first();

            // Prepare success response
            $response['status'] = 1;
            $response['message'] = 'Password updated successfully.';
            $response['data'] = $userData;
        } else {
            // User not found
            $response['status'] = 0;
            $response['errorcode'] = '200003';
            $response['message'] = 'User ID does not exist.';
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        $response['status'] = 0;
        $response['message'] = $e->validator->errors()->first();
    } catch (\Exception $e) {
        // Handle exceptions
        $response['status'] = 0;
        $response['errorcode'] = '200004';
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }

    // Return JSON response
    return response()->json($response);
}

public function suggested_user(Request $request)
{
    $response = [
        'status' => 0,
        'message' => '',
        'data' => null
    ];

    try {
        $authUserId = $request->input('user_id'); // sender or logged-in user

        // Subquery to get list of user IDs to exclude (blocked or declined)
        $excludedUserIds = DB::table('friend_requests')
            ->where(function ($query) use ($authUserId) {
                $query->where('from_user_id', $authUserId)
                      ->orWhere('to_user_id', $authUserId);
            })
            ->where(function ($query) {
                $query->where('status','!=',3) // declined
                      ->orWhere('is_blocked', 1); // blocked
            })
            ->pluck('from_user_id', 'to_user_id')
            ->flatMap(function ($value, $key) {
                return [$value, $key];
            })
            ->unique()
            ->toArray();

        // Fetch suggested users
        $user_details = DB::table('users')
            ->select('id', 'first_name', 'last_name', 'email', 'profile_image')
            ->where('user_status', 0)
            ->where('is_deleted', 0)
            ->where('user_type', 2)
            ->where('email_verified', 1)
            ->where('id', '!=', $authUserId)
            ->whereNotIn('id', $excludedUserIds)
            ->get()
            ->map(function ($user) {
                $user->profile_image = $user->profile_image
                    ? asset('public/uploads/profile_image/' . $user->profile_image)
                    : null;
                return $user;
            });

        $response['status'] = 1;
        $response['message'] = 'User Listing.';
        $response['data'] = ['user_list' => $user_details];

    } catch (\Exception $e) {
        $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    }

    return response()->json($response);
}


public function friend_requests(Request $request)
{
    $response = [
        'status' => 0,
        'message' => '',
    ];
    $fromUserId = $request->input('from_user_id');
    $toUserId = $request->input('to_user_id');

    if (empty($fromUserId)) {
        $response['errorcode'] = "40001";
        $response['message'] = "Sender user ID (from_user_id) is required.";
    } elseif (empty($toUserId)) {
        $response['errorcode'] = "40002";
        $response['message'] = "Receiver user ID (to_user_id) is required.";
    } elseif ($fromUserId == $toUserId) {
        $response['errorcode'] = "40003";
        $response['message'] = "You cannot send a friend request to yourself.";
    } else {
        try {
            $fromUser = User::find($fromUserId);
            $toUser = User::find($toUserId);

            if (!$fromUser || $fromUser->is_deleted) {
                $response['errorcode'] = "40004";
                $response['message'] = "Sender user not found.";
            } elseif (!$toUser || $toUser->is_deleted) {
                $response['errorcode'] = "40005";
                $response['message'] = "Receiver user not found.";
            } else {

                $isBlocked = DB::table('friend_requests')
                    ->where(function ($query) use ($fromUserId, $toUserId) {
                        $query->where(function ($q) use ($fromUserId, $toUserId) {
                            $q->where('from_user_id', $fromUserId)
                            ->where('to_user_id', $toUserId);
                        })->orWhere(function ($q) use ($fromUserId, $toUserId) {
                            $q->where('from_user_id', $toUserId)
                            ->where('to_user_id', $fromUserId);
                        });
                    })
                    ->where('is_blocked', 1)
                    ->exists();

                if ($isBlocked) {
                    $response['errorcode'] = "40008";
                    $response['message'] = "Cannot send request — user is blocked.";
                    return response()->json($response);
                }


                $existingRequest = DB::table('friend_requests')
                    ->where(function ($query) use ($fromUserId, $toUserId) {
                        $query->where('from_user_id', $fromUserId)->where('to_user_id', $toUserId);
                    })->orWhere(function ($query) use ($fromUserId, $toUserId) {
                        $query->where('from_user_id', $toUserId)->where('to_user_id', $fromUserId);
                    })->first();

                if ($existingRequest && $existingRequest->status == 1) {
                    $response['errorcode'] = "40006";
                    $response['message'] = "Friend request already sent or pending.";
                } elseif ($existingRequest && $existingRequest->status == 2) {
                    $response['errorcode'] = "40007";
                    $response['message'] = "Users are already friends.";
                }
                   else {

                        DB::table('friend_requests')->insert([
                            'from_user_id' => $fromUserId,
                            'to_user_id' => $toUserId,
                            'status' => 1,
                            'is_blocked' => 2,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $response['status'] = 1;
                        $response['message'] = "Friend request sent successfully.";
                    }
                }

        } catch (\Exception $e) {
            $response['errorcode'] = "50001";
            $response['message'] = "An unexpected error occurred: " . $e->getMessage();
        }
    }

    return response()->json($response);
}

public function pending_request_list(Request $request)
{
    $response = [
        'status' => 0,
        'message' => '',
        'data' => null
    ];

    try {
        $userId = $request->input('user_id');

        if (empty($userId)) {
            $response['errorcode'] = "40001";
            $response['message'] = "User ID is required.";
            return response()->json($response);
        }

        $is_user = User::find($userId);

        if (!$is_user || $is_user->is_deleted) {
            $response['errorcode'] = "40002";
            $response['message'] = "User not found.";
            return response()->json($response);
        }

        // Get pending friend requests
        $pendingRequests = DB::table('friend_requests')
            ->join('users', 'friend_requests.from_user_id', '=', 'users.id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.profile_image')
            ->where('friend_requests.to_user_id', $userId)
            ->where('friend_requests.status', 1) // Pending
            ->where('friend_requests.is_blocked', 2) // 2 = unblocked
            ->where('users.is_deleted', 0)
            ->where('users.email_verified', 1)
            ->get()
            ->map(function ($user) {
                $user->profile_image = $user->profile_image
                    ? asset('public/uploads/profile_image/' . $user->profile_image)
                    : null;
                return $user;
            });

        if ($pendingRequests->isEmpty()) {
            $response['errorcode'] = "40003";
            $response['message'] = "There are no pending requests.";
        } else {
            $response['status'] = 1;
            $response['message'] = "Pending friend requests.";
            $response['data'] = ['pending_requests' => $pendingRequests];
        }

    } catch (\Exception $e) {
        $response['message'] = "An unexpected error occurred: " . $e->getMessage();
    }

    return response()->json($response);
}

public function accept_request_list(Request $request)
{
    // echo "tstefe";die;
    $response = [
        'status' => 0,
        'message' => '',
        'data' => null
    ];

    try {
        $userId = $request->input('user_id');

        if (empty($userId)) {
            $response['errorcode'] = "40001";
            $response['message'] = "User ID is required.";
            return response()->json($response);
        }

        $is_user = User::find($userId);

        if (!$is_user || $is_user->is_deleted) {
            $response['errorcode'] = "40002";
            $response['message'] = "User not found.";
            return response()->json($response);
        }

        // Get pending friend requests
        $acceptRequests = DB::table('friend_requests')
            ->join('users', 'friend_requests.from_user_id', '=', 'users.id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.profile_image')
            ->where('friend_requests.to_user_id', $userId)
            ->where('friend_requests.status', 2) // Pending
            ->where('friend_requests.is_blocked', 2) // 2 = unblocked
            ->where('users.is_deleted', 0)
            ->where('users.email_verified', 1)
            ->get()
            ->map(function ($user) {
                $user->profile_image = $user->profile_image
                    ? asset('public/uploads/profile_image/' . $user->profile_image)
                    : null;
                return $user;
            });

        if ($acceptRequests->isEmpty()) {
            $response['errorcode'] = "40003";
            $response['message'] = "There are no request for accepting.";
        } else {
            $response['status'] = 1;
            $response['message'] = "Pending friend requests.";
            $response['data'] = ['accept_requests' => $acceptRequests];
        }

    } catch (\Exception $e) {
        $response['message'] = "An unexpected error occurred: " . $e->getMessage();
    }

    return response()->json($response);
}


public function professional_title()
{
    // echo "test";die;
    $response = [
        'status' => 0,
        'message' => '',
        'data' => null
    ];

    try {

        $professional_title_listing = DB::table('master_professional_title')
                                ->select('id', 'professional_title')
                                ->where('is_deleted','0')
                                ->where('is_active','1')
                                ->get();

            // print_r($user_details);die;
        $response['status'] = 1;
        $response['message'] = 'professional title listing';
        $response['data'] = ['professional_title_listing' => $professional_title_listing];

    } catch (\Exception $e) {
        $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    }

    return response()->json($response);
}

// public function home_page()
// {
//     // echo "test";die;
//     $response = [
//         'status' => 0,
//         'message' => '',
//         'data' => null
//     ];

//     try {

//         $event_listing = DB::table('events')
//                         ->where('is_deleted','0')
//                         ->where('status','1')
//                         ->get();

//     foreach ($event_listing as $value) {

//         $top_event_images = DB::table('event_gallery_images')
//             ->where('event_id', $value->id)
//             ->pluck('event_media') // Fetch only the images
//             ->toArray(); // Convert to array for easy handling

//         // Add catalogue details to the list
//         // $showtopRatedProduct = [];
//             $showEventList[] = [
//                 "event_id" => $value->id,
//                 "user_id" => $value->user_id,
//                 "event_name" => $value->event_name,
//                 "date_time" => $value->date_time,
//                 "address" => $value->address,
//                 "event_days" => json_decode($value->event_days),
//                 "ticket_quantity" => $value->ticket_quantity,
//                 "ticket_price" => $value->ticket_price,
//                 "start_time" => $value->start_time,
//                 "duration" => $value->duration,
//                 "description" => $value->description,
//                 "end_time" => $value->end_time,
//                 "latitude" => $value->latitude,
//                 "longitude" => $value->longitude,
//                 "event_media" => array_map(function ($image) {
//                     return url('public/upload/product_images/') . $image; // Append full URL
//                 }, $top_event_images),
//             ];
//         }


//             // print_r($showEventList);die;
//         $response['status'] = 1;
//         $response['message'] = 'Event listing';
//         $response['data'] = ['event_listing' => $showEventList];

//     } catch (\Exception $e) {
//         $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
//     }

//     return response()->json($response);
// }


    public function event_list()
    {
        $response = [
            'status' => 0,
            'message' => '',
            'data' => null
        ];

        try {
           $events = Event::with([
                        'coach',
                        'event_slots',
                        'joind_members.user',
                        'event_reviews',
                        'coach.event_reviews',
                    ])
                    ->where('is_deleted', '0')
                    ->where('status', '1')
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
                    'latitude'        => $event->latitude ?? '',
                    'longitude'       => $event->longitude ?? '',
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

            // Final response
            $response['status'] = 1;
            $response['message'] = 'Event listing';
            $response['data'] = ['event_listing' => $eventList];

        } catch (\Exception $e) {
            $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
        }

        return response()->json($response);
    }



    public function updateProfileImage(Request $request)
    {
        try {
            $user = Auth::user(); //  JWT Authenticated User
            $id = $user->id;

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or inactive.',
                ], 403);
            }

            $user = User::where('id', $id)
                ->where('user_status', 1)
                ->where('user_type', $request->user_type)
                ->first();

            if (!$request->hasFile('profile_image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No image file provided.'
                ], 400);
            }

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = "pro" . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/uploads/profile_image'), $imageName);
                $user->profile_image = $imageName;
            }
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully.',
                'profile_image'  => $user->profile_image
                    ? url('public/uploads/profile_image/' . $user->profile_image)
                    : '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token not valid or other error.',
                'error'   => $e->getMessage()
            ], 401);
        }
    }
}
