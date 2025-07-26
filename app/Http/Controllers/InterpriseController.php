<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;


class InterpriseController extends Controller
{
    public function profile(Request $request)
    {
        $userDetail = auth()->user();
        return view('business.profile', compact('userDetail'));
    }

    public function updateProfile(Request $request){
        
        $authId = auth()->id();
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "contact_number" => "required|digits:10|unique:users,contact_number,".$authId,
        ]);
       
        //dd($request->all());
        $userData = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "contact_number" => $request->contact_number,
            "Website_link" => $request->Website_link
        ];

         if($request->hasFile('profile_picture')){
            $file  = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/profile_image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $userData['profile_image'] = $filename;
        }

        User::where('id',$authId)->update($userData);
        return redirect()->back()->withSuccess("Successfully updated");
    }
}