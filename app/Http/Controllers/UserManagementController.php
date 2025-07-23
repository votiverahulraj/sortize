<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Professional;
use App\Models\UserService;
use App\Models\UserLanguage;
use App\Models\MasterEnquiry;


class UserManagementController extends Controller
{
    public function __construct()
    {
        if (Auth::guard("admin")->user()) {
            $user = Auth::guard("admin")->user();

            if ($user->user_type != 1) {
                Auth::guard("admin")->logout();
                return redirect()->route("admin.login")->with("warning", "You are not authorized as admin.");
            }
        }
    } 

    public function userList()
    {
        $users = DB::table('users')
            ->join('master_country', 'master_country.country_id', '=', 'users.country_id')
            ->where('user_type', 2)
            ->where('is_deleted', 0)
            ->select('users.*', 'master_country.country_name')
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return view('admin.user_list', compact('users'));
    }
    public function updateUserStatus(Request $request)
    {
        $user = User::find($request->user);
        $user->user_status = $request->status;
        $user->save();
    }
    public function deleteUser(Request $request)
    {
        //This function is for ajax to delete the user
        $user = User::find($request->user);
        $user->is_deleted = 1;
        $user->save();
    }
    public function addUser(Request $request, $id = null)
    {
        $country = DB::table('master_country')->where('country_status', 1)->get();
        $user_detail = $state = $city = "";
        if ($id != null) {
            $user_detail = DB::table('users')->where('id', $id)->first();
            $state = DB::table('master_state')->where('state_country_id', $user_detail->country_id)->get();
            $city = DB::table('master_city')->where('city_state_id', $user_detail->state_id)->get();
        }
        if ($request->isMethod('post')) {
            $user = User::find($request->user_id);
            if (!$user) {
                $user = new User();
            }

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = "pro" . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/uploads/profile_image'), $imageName);
                $user->profile_image = $imageName;
            }

            $user->first_name       = $request->first_name;
            $user->last_name        = $request->last_name;
            $user->email            = $request->email;
            $user->contact_number   = $request->contact_number;
            if ($request->password != '') {
                $user->password         = $request->password;
            }

            $user->gender           = $request->gender;
            $user->country_id       = $request->country_id;
            $user->state_id         = $request->state_id;
            $user->city_id          = $request->city_id;
            $user->user_type        = 2;
            $user->user_timezone    = $request->user_time;
            $user->email_verified   = 1;
            $user->created_at       = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->route("admin.userList")->with("success", "User profile updated successfully.");
        }

        return view('admin.add_user', compact('country', 'user_detail', 'state', 'city'));
    }
    public function viewUser($id)
    {
        if ($id != null) {
            $user_detail = DB::table('users')
                ->join('master_country as mc', 'users.country_id', '=', 'mc.country_id')
                ->join('master_state as ms', 'users.state_id', '=', 'ms.state_id')
                ->join('master_city as c', 'users.city_id', '=', 'c.city_id')
                ->select('users.*', 'mc.country_name', 'ms.state_name', 'c.city_name')
                ->where('id', $id)->first();

            $enquiry = DB::table('enquiry')
                ->join('users as user', 'user.id', '=', 'enquiry.user_id')
                ->select(
                    'user.id as user_id',
                    'user.first_name as user_first_name',
                    'user.last_name as user_last_name',
                    'user.email as user_email',
                    'user.contact_number as user_contact_number',
                    'enquiry.enquiry_status as user_enquiry_status',
                    'enquiry.id',
                    'enquiry.enquiry_title',
                    'enquiry.enquiry_detail'
                )->where('enquiry.user_id', $id)
                ->orderBy('enquiry.id', 'DESC')
                ->paginate(20);
        }
        return view('admin.view_user_profile', compact('user_detail', 'enquiry'));
    }
    public function interpriseList()
    {
        
        $users = DB::table('users')
            ->where('user_type', 3)
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return view('admin.interprise_list', compact('users'));
    }
    public function addInterprise(Request $request)
    {
            $id=null;
            if(isset($request->user_id) && !empty($request->user_id)){
                $id = $request->user_id;
            }
            $rules = [
                "company_type" => "required",
                "first_name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|email|unique:users,email" . ($id ? ",$id" : ""),
                "contact_number" => "required|integer|digits:10",
            ];

            if (!$id) {
                $rules['password'] = 'required|string|min:5|confirmed';
            } 
             $validated = $request->validate($rules);

            $user = User::find($request->user_id);
            if (!$user) {
                $user = new User();
            }
            $user->company_type       = $request->company_type;
            $user->first_name       = $request->first_name;
            $user->last_name        = $request->last_name;
            $user->email            = $request->email;
            $user->contact_number   = $request->contact_number;
            $user->c_name        = $request->c_name;
            if ($request->password != '') {
                $user->password         = $request->password;
            }
            $user->Website_link = $request->Website_link;
            $user->city_id          = $request->city_id;
            $user->is_verified      = $request->is_verified;
            $user->user_type        = 3;
            $user->user_timezone    = $request->user_time;
            $user->email_verified   = 1;
            $user->is_verified   = 1;
            $user->created_at       = date('Y-m-d H:i:s');
            $user->save();

             return redirect()->route("admin.interpriseList")->with("success", "Interprise profile updated successfully.");


        // return view('admin.add_coach', compact('category', 'mode', 'type', 'subtype', 'country', 'user_detail', 'state', 'city', 'profession', 'language', 'service', 'selectedServiceIds', 'selectedLanguageIds'));
    }
    public function addProfessional(Request $request, $id = null)
    {
        //This function is for add coach professional
        $user_detail = $profession = $document = "";
        if ($id != null) {
            $user_detail = DB::table('users')->where('id', $id)->first();
            $profession = DB::table('user_professional')->where('user_id', $id)->first();
            $document = DB::table('user_document')->where('user_id', $id)->get();
        }

        if ($request->isMethod('post')) {
            $user_id = $request->user_id;
            $professional = Professional::where('user_id', $user_id)->first();

            if (!$professional) {
                $professional = new Professional();
                $professional->user_id = $user_id;
            }

            $professional->experience    = $request->experiance;
            $professional->price        = $request->price;
            $professional->video_link   = $request->video_introduction;
            $professional->website_link = $request->website;
            $professional->fb_link      = $request->facebook;
            $professional->insta_link = $request->instagram;
            $professional->linkdin_link = $request->linkdin;
            $professional->booking_link = $request->booking;
            $professional->objective   = $request->objective;
            $professional->save();

            $user = User::find($request->user_id);
            $user->detailed_bio = $request->detailed_bio;
            $user->exp_and_achievement = $request->exp_and_achievement;
            $user->save();

            //Now add the files
            if ($request->hasFile('document_file')) {
                $documents = $request->file('document_file');
                $types = $request->input('document_type');
                $docIds = $request->input('doc_id', []); // Optional

                foreach ($documents as $index => $file) {
                    if ($file && $file->isValid()) {
                        $filename = $file->getClientOriginalName();
                        $imageName = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('/uploads/documents'), $imageName);

                        $documentData = [
                            'document_file' => $imageName,
                            'original_name' => $filename,
                            'document_type' => $types[$index] ?? null,
                            'updated_at' => now()
                        ];

                        // Check if we're updating or inserting
                        if (!empty($docIds[$index])) {
                            // Update existing document
                            DB::table('user_document')
                                ->where('id', $docIds[$index])
                                ->update($documentData);
                        } else {
                            // Insert new document
                            $documentData['user_id'] = $request->user_id;
                            $documentData['created_at'] = now();

                            DB::table('user_document')->insert($documentData);
                        }
                    }
                }
            }

            return redirect()->route("admin.interpriseList")->with("success", "Professional profile updated successfully.");
        }
        return view('admin.add_professional', compact('user_detail', 'profession', 'document'));
    }
    public function deleteDocument(Request $request)
    {
        $doc = DB::table('user_document')->where('id', $request->id)->first();

        if ($doc) {
            // Delete the file from filesystem
            $path = public_path('/uploads/documents/' . $doc->document_file);
            if (file_exists($path)) {
                unlink($path);
            }

            // Delete from DB
            DB::table('user_document')->where('id', $request->id)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function interpriseProfile(Request $request, $id = null)
    {

       $user_detail = DB::table('users')->where('id', $id)->first();
          
        return view('admin.interprise_profile',compact('user_detail'));
    }
    public function viewCoach($id)
    {
        //This function is for view the coach profile
        if ($id != null) {
            $user_detail = DB::table('users')
                ->where('id', $id)->first();
        }
        return view('admin.view_coach_profile', compact('user_detail'));
    }

    public function enquiry_status(Request $request)
    {
        $user = MasterEnquiry::find($request->user);
        $user->enquiry_status = $request->status;
        $user->save();
    }
    public function bulkDeleteusr(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids) {
            return redirect()->back()->with('error', 'No user selected.');
        }

        User::whereIn('id', $ids)->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Selected user deleted successfully.');
    }
    public function bulkDeleteCoach(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids) {
            return redirect()->back()->with('error', 'No Coach selected.');
        }

        User::whereIn('id', $ids)->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Selected Coach deleted successfully.');
    }

    public function view_user_enquiry($id)
    {

        //dd($id);

        if ($id != null) {

            $user_detail = DB::table('enquiry')
                ->join('users as user', 'user.id', '=', 'enquiry.user_id')
                ->leftJoin('master_country', 'user.country_id', '=', 'master_country.country_id')
                ->leftJoin('master_state', 'user.state_id', '=', 'master_state.state_id')
                ->leftJoin('master_city', 'user.city_id', '=', 'master_city.city_id')
                ->select(
                    'user.id as user_id',
                    'user.first_name as user_first_name',
                    'user.last_name as user_last_name',
                    'user.email as user_email',
                    'user.contact_number as user_contact_number',
                    'user.professional_title as user_professional_title',
                    'user.short_bio as user_short_bio',
                    'user.gender as user_gender',
                    'user.detailed_bio as user_detailed_bio',
                    'user.profile_image as user_profile_image',
                    'master_country.country_name',
                    'master_state.state_name',
                    'master_city.city_name',
                    'enquiry.id',
                    'enquiry.enquiry_title',
                    'enquiry.enquiry_detail'
                )
                ->where('enquiry.id', $id)
                ->where('user.user_type', 2)
                ->where('user.user_status', 1)
                ->first();


            $enquiry_detail = DB::table('enquiry')
                ->join('users', 'users.id', '=', 'enquiry.user_id')
                ->select('users.*', 'enquiry.enquiry_title', 'enquiry.enquiry_detail')
                ->where('enquiry.id', $id)
                ->first();
        }

        return view('admin.view_user_enquiry', compact('user_detail', 'enquiry_detail', 'id'));
    }


    public function view_coach_enquiry($id)
    {

        //dd($id);

        if ($id != null) {

            $coach_detail = DB::table('enquiry')
                ->join('users as coach', 'coach.id', '=', 'enquiry.coach_id')
                ->leftJoin('master_country', 'coach.country_id', '=', 'master_country.country_id')
                ->leftJoin('master_state', 'coach.state_id', '=', 'master_state.state_id')
                ->leftJoin('master_city', 'coach.city_id', '=', 'master_city.city_id')
                ->select(
                    'coach.id as coach_id',
                    'coach.first_name as coach_first_name',
                    'coach.last_name as coach_last_name',
                    'coach.email as coach_email',
                    'coach.contact_number as coach_contact_number',
                    'coach.professional_title as coach_professional_title',
                    'coach.short_bio as coach_short_bio',
                    'coach.gender as coach_gender',
                    'coach.detailed_bio as coach_detailed_bio',
                    'coach.profile_image as coach_profile_image',
                    'master_country.country_name',
                    'master_state.state_name',
                    'master_city.city_name',
                    'enquiry.id',
                    'enquiry.enquiry_title',
                    'enquiry.enquiry_detail'
                )
                ->where('enquiry.id', $id)
                ->where('coach.user_type', 3)
                ->where('coach.user_status', 1)
                ->first();


            $enquiry_detail = DB::table('enquiry')
                ->join('users', 'users.id', '=', 'enquiry.user_id')
                ->select('users.*', 'enquiry.enquiry_title', 'enquiry.enquiry_detail')
                ->where('enquiry.id', $id)
                ->first();
        }

        return view('admin.view_coach_enquiry', compact('coach_detail', 'enquiry_detail', 'id'));
    }

    //  public function enquiry_status(Request $request)
    // {
    //     $user = MasterEnquiry::find($request->user);
    //     $user->enquiry_status=$request->status;
    //     $user->save();
    // }
}
