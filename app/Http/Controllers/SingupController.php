<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SingupController extends Controller
{
    public function store(Request $request)
    {
        $errors = [];
        if (empty($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email non valida.';
        } else if (DB::table('users')->where('email', $request->email)->exists()) {
            $errors[] = 'Email già registrata.';
        }
        if (empty($request->password) || $request->password !== $request->confirm_password) {
            $errors[] = 'Le password non coincidono o sono vuote.';
        }
        if (empty($request->first_name)) $errors[] = 'Il nome è obbligatorio.';
        if (empty($request->last_name)) $errors[] = 'Il cognome è obbligatorio.';
        if (empty($request->birthday) || !strtotime($request->birthday)) $errors[] = 'Data di nascita non valida.';
        if (empty($request->city)) $errors[] = 'La città è obbligatoria.';
        if (empty($request->province)) $errors[] = 'La provincia è obbligatoria.';
        if (empty($request->phone)) $errors[] = 'Il telefono è obbligatorio.';

        if (count($errors) > 0) {
            return redirect()->back()->withInput()->withErrors($errors);
        }        
        $userId = DB::table('users')->insertGetId([
            'email' => $request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'city' => $request->city,
            'province' => $request->province,
            'phone' => $request->phone,
            'accept_marketing' => $request->accept_marketing ?? 0,
            'created_at' => now(),
        ]);

        return redirect('/')->withCookie(cookie('loggato', $userId, 60))->with('success', 'Registrazione completata!');
    }
}
