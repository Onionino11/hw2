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
        
        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')            
            ->limit(5)
            ->get();
            
        $array = [
            'user' => $user,
            'ordini' => $ordini
        ];
        return view('profilo', $array);
    }
}
