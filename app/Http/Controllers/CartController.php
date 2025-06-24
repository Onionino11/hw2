<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{    public function api(Request $request)
    {
        $user_id = $request->cookie('loggato');
        if (!$user_id) {
            return json_encode(['success' => false, 'error' => 'Utente non loggato']);
        }
        try {
            $carrello = DB::table('carrelli')->where('user_id', $user_id)->first();
            $items = [];
            if ($carrello) {
                $items = DB::table('carrello_prodotti')
                    ->where('carrello_id', $carrello->id)
                    ->select('prodotto_id', 'nome', 'descrizione', 'prezzo', 'quantita')                    
                    ->get();
            }
            return json_encode(['success' => true, 'items' => $items]);
        } catch (\Exception $e) {
            return json_encode(['success' => false, 'error' => 'DB error', 'msg' => $e->getMessage()]);
        }
    }
      public function add(Request $request)
    {
        $user_id = $request->cookie('loggato');
        if (!$user_id) {
            return json_encode(['success' => false, 'error' => 'Utente non loggato']);
        }
        
        $id = intval($request->input('id'));
        $nome = $request->input('nome', '');
        $descrizione = $request->input('descrizione', '');
        $prezzo = floatval($request->input('prezzo', 0.0));        
        try {
            $carrello = DB::table('carrelli')->where('user_id', $user_id)->first();
            if (!$carrello) {
                $carrello_id = DB::table('carrelli')->insertGetId(['user_id' => $user_id, 'totale' => 0.00]);
            } else {
                $carrello_id = $carrello->id;
            }
            $prodotto = DB::table('carrello_prodotti')
                ->where('carrello_id', $carrello_id)
                ->where('prodotto_id', $id)
                ->first();
                
            if ($prodotto) {
                DB::table('carrello_prodotti')
                    ->where('id', $prodotto->id)
                    ->update(['quantita' => $prodotto->quantita + 1]);
            } else {
                DB::table('carrello_prodotti')->insert([
                    'carrello_id' => $carrello_id,
                    'prodotto_id' => $id,
                    'nome' => $nome,
                    'descrizione' => $descrizione,
                    'prezzo' => $prezzo,
                    'quantita' => 1
                ]);
            }
            
            $totale = DB::table('carrello_prodotti')
                ->where('carrello_id', $carrello_id)
                ->select(DB::raw('SUM(prezzo * quantita) as totale'))
                ->first()->totale ?? 0.00;            
            DB::table('carrelli')->where('id', $carrello_id)->update(['totale' => $totale]);
            
            return json_encode(['success' => true]);
        } catch (\Exception $e) {
            return json_encode(['success' => false, 'error' => 'DB error', 'msg' => $e->getMessage()]);
        }
    }      public function remove(Request $request)
    {
        $user_id = $request->cookie('loggato');
        if (!$user_id) {
            return json_encode(['success' => false, 'error' => 'Utente non loggato']);
        }
        $id = intval($request->input('id'));
        $remove_all = $request->input('remove_all', false);
        
        try {            
            $carrello = DB::table('carrelli')->where('user_id', $user_id)->first();
            if (!$carrello) {
                return json_encode(['success' => false, 'error' => 'Nessun carrello']);
            }
            
            $prodotto = DB::table('carrello_prodotti')
                ->where('carrello_id', $carrello->id)
                ->where('prodotto_id', $id)
                ->first();
                  if ($prodotto) {
                if ($remove_all) {
                    DB::table('carrello_prodotti')->where('id', $prodotto->id)->delete();
                } else if ($prodotto->quantita > 1) {
                    DB::table('carrello_prodotti')
                        ->where('id', $prodotto->id)
                        ->update(['quantita' => $prodotto->quantita - 1]);
                } else {
                    DB::table('carrello_prodotti')->where('id', $prodotto->id)->delete();
                }
            }
            
            $totale = DB::table('carrello_prodotti')
                ->where('carrello_id', $carrello->id)
                ->select(DB::raw('SUM(prezzo * quantita) as totale'))
                ->first()->totale ?? 0.00;            
                DB::table('carrelli')->where('id', $carrello->id)->update(['totale' => $totale]);
              return json_encode(['success' => true]);
        } catch (\Exception $e) {
            return json_encode(['success' => false, 'error' => 'DB error', 'msg' => $e->getMessage()]);
        }
    }
}
