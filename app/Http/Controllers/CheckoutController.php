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
    {        $user_id = $request->cookie('loggato');
        if (!$user_id) {
            return redirect()->route('login');
        }
        
        $errors = [];
        
        if (!$request->input('first_name')) {
            $errors[] = 'Il nome è obbligatorio.';
        }
        
        if (!$request->input('last_name')) {
            $errors[] = 'Il cognome è obbligatorio.';
        }
        
        if (!$request->input('phone')) {
            $errors[] = 'Il telefono è obbligatorio.';
        }
        
        $consegna = $request->input('consegna');
        if (!$consegna || !in_array($consegna, ['ritiro', 'tavolo', 'domicilio'])) {
            $errors[] = 'Seleziona un metodo di consegna valido.';
        }
        
        $pagamento = $request->input('pagamento');
        if (!$pagamento || !in_array($pagamento, ['contanti', 'carta'])) {
            $errors[] = 'Seleziona un metodo di pagamento valido.';
        }
        
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
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
            for ($i = 0; $i < count($items); $i++) {
                $totale += $items[$i]->prezzo * $items[$i]->quantita;
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
                'updated_at' => now(),            ]);
            
            for ($i = 0; $i < count($items); $i++) {
                DB::table('ordini_prodotti')->insert([
                    'ordine_id' => $ordine_id,
                    'prodotto_id' => $items[$i]->prodotto_id,
                    'nome' => $items[$i]->nome,
                    'prezzo' => $items[$i]->prezzo,
                    'quantita' => $items[$i]->quantita,
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
