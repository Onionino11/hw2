<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{    public function index(Request $request)
    {
        $user_id = $request->cookie('loggato');
        $userData = [
            'ordine_inviato' => false,
            'errore_ordine' => session('error') ?? '',
            'riepilogo' => [],
            'totale' => 0
        ];
        
        if ($user_id) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                $userData['first_name'] = $user->first_name;
                $userData['last_name'] = $user->last_name;
                $userData['phone'] = $user->phone;
            }
        }
        
        return view('checkout', $userData);
    }

    public function processOrder(Request $request)
    {

        $user_id = $request->cookie('loggato');
        if (!$user_id) {
            return redirect()->route('login');
        }        try {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'consegna' => 'required|in:ritiro,tavolo,domicilio',
                'pagamento' => 'required|in:contanti,carta',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }


        $note = $request->input('note', '');
        
        try {
            $carrello = DB::table('carrelli')->where('user_id', $user_id)->first();
            if (!$carrello) {
                return back()->withErrors(['error' => 'Nessun carrello trovato.']);
            }
            
            $carrello_id = $carrello->id;
            
            $items = DB::table('carrello_prodotti')
                ->where('carrello_id', $carrello_id)
                ->get()
                ->toArray();
            
            $totale = 0;
            foreach ($items as $item) {
                $totale += $item->prezzo * $item->quantita;
            }
            

            if (count($items) === 0) {
                return back()->withErrors(['error' => 'Il carrello è vuoto.']);
            }
            

            $ordine_id = DB::table('ordini')->insertGetId([
                'user_id' => $user_id,
                'totale' => $totale,
                'note' => $note,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone' => $request->input('phone'),
                'consegna' => $request->input('consegna'),
                'pagamento' => $request->input('pagamento'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            foreach ($items as $item) {
                DB::table('ordini_prodotti')->insert([
                    'ordine_id' => $ordine_id,
                    'prodotto_id' => $item->prodotto_id,
                    'nome' => $item->nome,
                    'prezzo' => $item->prezzo,
                    'quantita' => $item->quantita,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            DB::table('carrello_prodotti')->where('carrello_id', $carrello_id)->delete();
            DB::table('carrelli')->where('id', $carrello_id)->update(['totale' => 0.00]);
            
            return view('checkout', [
                'ordine_inviato' => true,
                'riepilogo' => $items,
                'totale' => $totale
            ]);
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Errore durante il salvataggio dell\'ordine: ' . $e->getMessage()]);
        }
    }
}
