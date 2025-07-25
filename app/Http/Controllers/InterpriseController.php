<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class InterpriseController extends Controller
{
    public function profile(Request $request)
    {
        $userDetail = auth()->user();
        return view('business.profile', compact('userDetail'));
    }
}