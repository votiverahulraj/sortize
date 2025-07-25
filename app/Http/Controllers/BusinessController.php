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

class BusinessController extends Controller
{

	 public function signup(Request $request)
    {

         return view('business.register');

    }

     public function enerpriseStore(Request $request)
    {
        //dd($request->all());
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users",
            "contact_number" => "required|integer|digits:10",
            "password" => "required|min:5|confirmed" 
        ]);

      
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
            return response()->json([
                "success" => true,
                "redirect" => route('bussiness.login'),
                "message"=> "signup successfully" 
            ],201);
   
        
    }

    public function login(Request $request)
    {
    	return view('business.login');
    }

     public function Enterpriselogin(Request $request)
    {
        if ($request->isMethod('post'))
        {
        	
            if(Auth::guard("web")->attempt(["email" => $request->email,"password" => $request->password])) {

                $user = Auth::guard("web")->user();

               // dd($user);

                if ($user->user_type != 3)
                {
                    Auth::guard("web")->logout();
                    return redirect()->back()->with("warning", "You are not authorized as admin.");
                }
                if ($user->is_deleted == 3)
                {
                    Auth::guard("web")->logout();
                    return redirect()->back()->with("warning", "Your account is not activated by administrator.");
                }

                return redirect()->route("interprise.dashboard");
            }else{
                echo "Credentails do not matches our record.";
                 Session::flash('message', "Credentails do not matches our record");
                return redirect()->back()->withErros(["email" => "Credentails do not matches our record."]);
            }
        }
        if(Auth::guard("web")->user())
        {
            $user = Auth::guard("web")->user();

            if ($user->user_type != 3)
            {
                Auth::guard("interprise")->logout();
                return redirect()->route("interprise.login")->with("warning", "You are not authorized as admin.");
            }
            return redirect()->route("business.dashboard");
        }
        else
        {
            return view('business.login');
        }

    }
    public function logout()
    {
    	//echo "hiii";die;
        Auth::guard('web')->logout();
        return redirect()->route('interprise.login');
    }

	public function dashboard(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();

        $evenrCount = DB::table('events')->where('is_deleted', '=', 0)->count();

        //dd($evenrCount);
     
    	return view('business.dashboard', compact('userCount','evenrCount'));
    }
	
	public function createEvent(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();
      // dd($userCount);
    	return view('business.create-event', compact('userCount'));
    }


    public function eventList(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();
      // dd($userCount);
    	return view('business.event-list', compact('userCount'));
    }

    public function createTicket(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();
      // dd($userCount);
    	return view('business.create-ticket', compact('userCount'));
    }

    public function ticketList(Request $request)
    {
       $userCount = DB::table('users')->where('user_type', '=', 3)->where('is_deleted', '=', 0)->count();
      // dd($userCount);
    	return view('business.ticket-list', compact('userCount'));
    }
	
     public function getstate(Request $request)
    {

        $state = DB::table('master_state')->where('state_country_id', '=', $request->country_id)->orderBY('state_name', 'asc')->get();

        print_r($state);die;

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

}