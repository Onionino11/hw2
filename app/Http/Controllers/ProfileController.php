<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Cookie::has('loggato')) {
            return redirect('singup');
        }
        
        $userId = Cookie::get('loggato');
        $user = DB::table('users')->find($userId);
        
        if (!$user) {
            return redirect('singup');
        }
         
        return view('profilo')->with('user', $user);
    }
}
