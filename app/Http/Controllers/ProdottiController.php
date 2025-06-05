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
            return response()->json(['error' => 'Categoria non trovata'], 400);
        }
        $cat = $map[$categoria];
        $prodotti = DB::table('prodotti')
            ->where('categoria', $cat)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json(['results' => $prodotti]);
    }

    public function api($categoria, $numero = 10)
    {
        $query = $categoria;
        $number = $numero;
        $apiKey = '9dde7ae366c84c1d943b6f3567ff7f2b';
        $url = "https://api.spoonacular.com/recipes/complexSearch?query=$query&number=$number&apiKey=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            http_response_code(500);
            curl_close($ch);
            return response()->json(['error' => 'Errore nella richiesta: ' . curl_error($ch)], 500);
        }
        curl_close($ch);
        return response($result, 200)->header('Content-Type', 'application/json');
    }
}
