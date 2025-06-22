<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Mostra la lista degli ordini dell'utente.
     */
    public function index()
    {
        // Verifica se l'utente è loggato
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return redirect('singup');
        }

        // Recupera l'utente
        $user = DB::table('users')->find($userId);
        if (!$user) {
            return redirect('singup');
        }

        // Recupera gli ordini dell'utente
        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Per ogni ordine, recupera i prodotti associati
        foreach ($ordini as $ordine) {
            $ordine->prodotti = DB::table('ordini_prodotti')
                ->where('ordine_id', $ordine->id)
                ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
                ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
                ->get();
        }

        return view('ordini', compact('user', 'ordini'));
    }

    /**
     * Mostra i dettagli di un singolo ordine.
     */
    public function show($id)
    {
        // Verifica se l'utente è loggato
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return redirect('singup');
        }

        // Recupera l'ordine specifico dell'utente
        $ordine = DB::table('ordini')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$ordine) {
            return redirect()->route('ordini')->with('error', 'Ordine non trovato o non autorizzato');
        }

        // Recupera i prodotti dell'ordine
        $prodotti = DB::table('ordini_prodotti')
            ->where('ordine_id', $id)
            ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
            ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
            ->get();

        return view('dettaglio-ordine', compact('ordine', 'prodotti'));
    }

    /**
     * API per ottenere gli ordini di un utente in formato JSON.
     */
    public function getOrdini()
    {
        // Verifica se l'utente è loggato
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Utente non autorizzato'], 401);
        }

        // Recupera gli ordini dell'utente
        $ordini = DB::table('ordini')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Per ogni ordine, recupera i prodotti associati
        foreach ($ordini as $ordine) {
            $ordine->prodotti = DB::table('ordini_prodotti')
                ->where('ordine_id', $ordine->id)
                ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
                ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
                ->get();
        }

        return response()->json(['success' => true, 'ordini' => $ordini]);
    }

    /**
     * API per ottenere i dettagli di un singolo ordine in formato JSON.
     */
    public function getOrdine($id)
    {
        // Verifica se l'utente è loggato
        $userId = Cookie::get('loggato');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Utente non autorizzato'], 401);
        }

        // Recupera l'ordine specifico dell'utente
        $ordine = DB::table('ordini')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$ordine) {
            return response()->json(['success' => false, 'message' => 'Ordine non trovato o non autorizzato'], 404);
        }

        // Recupera i prodotti dell'ordine
        $prodotti = DB::table('ordini_prodotti')
            ->where('ordine_id', $id)
            ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
            ->select('prodotti.nome', 'prodotti.immagine', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
            ->get();

        $ordine->prodotti = $prodotti;

        return response()->json(['success' => true, 'ordine' => $ordine]);
    }
}
