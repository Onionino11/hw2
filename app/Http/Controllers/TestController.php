<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function home()
    {
        return view('welcome');
    }

    public function test()
    {
        echo "this is a test route!";
        echo "<p>TestController funziona</p>";
    }

    public function array(){
        return [1,2,3,4];
    }
        
}
