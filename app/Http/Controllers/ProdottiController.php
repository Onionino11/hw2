<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdottiController extends Controller
{

    public function db($categoria, $numero = 10)
    {
        
        $map = [
            'snac' => 1,
            'hamburger' => 3,
            'pasta' => 2,
            'salad' => 4,
            'drink' => 5,
            'dessert' => 6
        ];

        if (!array_key_exists($categoria, $map)) {
            return json_encode(['error' => 'Categoria non trovata'], 400);
        }
        $cat = $map[$categoria];
        $prodotti = DB::table('prodotti')
            ->where('categoria', $cat)
            ->orderBy('id', 'asc')
            ->get();

        return json_encode(['results' => $prodotti]);
    }

}
