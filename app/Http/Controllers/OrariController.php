<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrariController extends Controller
{
    public function getOrari()
    {
        $url = 'https://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="fast_food"]["name"="Maluburger"];out;';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => 'Errore nella richiesta: ' . curl_error($ch)], 500);
        }
        curl_close($ch);
        return response($result, 200)->header('Content-Type', 'application/json');
    }
}
