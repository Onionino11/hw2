<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function loadCategorie()
    {
        $categorie = DB::table('categoria')->get();
        return json_encode($categorie);
    }

}
