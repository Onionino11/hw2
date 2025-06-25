<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\OrariController;
use App\Http\Controllers\AuthCookieController;
use App\Http\Controllers\SingupController;
use App\Http\Controllers\ProdottiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('index');
})->name('home');


Route::get('/prova', [TestController::class, 'test'] );
Route::get('/array', [TestController::class, 'array'] );
Route::get('/pro',function(){return redirect('/prova');});
Route::get('/categorie', [CategoriaController::class, 'loadCategorie'] );
Route::get('/orari', [OrariController::class, 'getOrari'] );

Route::post('/login-cookie', [AuthCookieController::class, 'login']);
Route::get('/logout-cookie', [AuthCookieController::class, 'logout']);
Route::get('/singup', function () {
    return view('singup');
});
Route::post('/singup', [SingupController::class, 'store']);
Route::get('db/{categoria}/{numero?}', [ProdottiController::class, 'db']);
Route::get('api/{categoria}/{numero}', [ProdottiController::class, 'api']);

Route::get('/PER_INIZIARE', function() {
    return view('prodotti_view')->with('categoria', 'snac')->with('title','Per iniziare');
});
Route::get('/MALU PROMO MENU', function() {
    return view('prodotti_view')->with('categoria', 'hamburger')->with('title','MALU PROMO MENU');
});
Route::get('/MALU LIGHT', function() {
    return view('prodotti_view')->with('categoria', 'salad')->with('title','MALU LIGHT');
});
Route::get('/MALU BURGER (SOLO PANINO)', function() {
    return view('prodotti_view')->with('categoria', 'pasta')->with('title','MALU BURGER (SOLO PANINO)');
});
Route::get('/BEVANDE', function() {
    return view('prodotti_view')->with('categoria', 'drink')->with('title','Bevande');
});
Route::get('/DOLCI', function() {
    return view('prodotti_view')->with('categoria', 'dessert')->with('title','DOLCI');
});


Route::get('/api/cart', [CartController::class, 'api']);
Route::post( '/api/cart/add', [CartController::class, 'add']);
Route::match(['get', 'post'], '/api/cart/remove', [CartController::class, 'remove']);


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processOrder'])->name('checkout.process');


Route::get('/profilo', [ProfileController::class, 'index'])->name('profilo');


Route::get('/ordini', [OrderController::class, 'index'])->name('ordini');
Route::get('/ordini/{id}', [OrderController::class, 'show'])->name('ordini.show');
Route::get('/api/ordini', [OrderController::class, 'getOrdini']);
Route::get('/api/ordini/{id}', [OrderController::class, 'getOrdine']);