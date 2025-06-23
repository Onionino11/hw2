<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return redirect('singup');
        }

        $user = DB::table('users')->find($userId);
        if (!$user) {
            return redirect('singup');
        }

        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        for ($i = 0; $i < count($ordini); $i++) {
            $ordini[$i]->prodotti = DB::table('ordini_prodotti')
                ->where('ordine_id', $ordini[$i]->id)
                ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
                ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
                ->get();
        }

        return view('ordini', compact('user', 'ordini'));
    }

    public function show($id)
    {
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return redirect('singup');
        }

        $ordine = DB::table('ordini')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$ordine) {
            return redirect()->route('ordini')->with('error', 'Ordine non trovato o non autorizzato');
        }

        $prodotti = DB::table('ordini_prodotti')
            ->where('ordine_id', $id)
            ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
            ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
            ->get();

        return view('dettaglio-ordine', compact('ordine', 'prodotti'));
    }

    public function getOrdini()
    {
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return json_encode(['success' => false, 'message' => 'Utente non autorizzato']);
        }

        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        for ($i = 0; $i < count($ordini); $i++) {
            $ordini[$i]->prodotti = DB::table('ordini_prodotti')
                ->where('ordine_id', $ordini[$i]->id)
                ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
                ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
                ->get();
        }

        return json_encode(['success' => true, 'ordini' => $ordini]);
    }

    public function getOrdine($id)
    {
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return json_encode(['success' => false, 'message' => 'Utente non autorizzato']);
        }

        $ordine = DB::table('ordini')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$ordine) {
            return json_encode(['success' => false, 'message' => 'Ordine non trovato o non autorizzato']);
        }

        $prodotti = DB::table('ordini_prodotti')
            ->where('ordine_id', $id)
            ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
            ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
            ->get();

        $ordine->prodotti = $prodotti;

        return json_encode(['success' => true, 'ordine' => $ordine]);
    }
}
