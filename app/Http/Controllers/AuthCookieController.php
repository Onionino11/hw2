<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthCookieController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = \DB::table('users')->where('email', $email)->first();
        if ($user && $user->password === $password) {
            return redirect('/')->withCookie(cookie('loggato', $user->id, 60));
        } elseif ($user) {

            return redirect('/')->with('err', 1);
        } else {

            return redirect('/singup');
        }
    }

    public function logout(Request $request)
    {
        return redirect('/')->withCookie(cookie('loggato', '', -1));
    }
}
