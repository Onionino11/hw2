<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    /**
     * Mostra la pagina del profilo utente
     */
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
        
        // Recupera gli ordini dell'utente
        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return view('profilo', compact('user', 'ordini'));
    }
}
