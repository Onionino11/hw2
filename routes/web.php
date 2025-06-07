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

Route::get('/test/{param1?}/{param2?}', function ($a='Prova a passare un parametro', $b='e un secondo parametro') {
    echo "<h1>This is a test route!</h1>";
    echo "<p>Laravel is working correctly.</p>";
    echo "<form method='POST'>
        <input type='hidden' name='_token' value='" . csrf_token() . "'>
        <button type='submit'>Submit</button>
    </form>";
    echo "<p>Parameters received: <br>
        - 1) $a <br>
        - 2) $b</p>";
    echo "<h4>Ricorda per rendere opzionale un parametro devi usare questa sintassi</h4>";
    echo "<p>Route::get('/test/{param1?}', function (\$a='Prova a passare un parametro') { codice... });</p>";
    echo "<h4>Per passare un parametro obbligatorio devi usare questa sintassi</h4>";
    echo "<p>Route::get('/test/{param1}', function (\$a) { codice... });</p>";
});

Route::post('/test', function (Request $request) {
    echo "<h1>Form submitted successfully!</h1>";
    echo "<p>-    Tutte le richieste POST nelle route in web.php devono contenere un campo chiamato _token <br>
        -    Il valore è fornito da Laravel (varia ad ogni richiesta) <br>
        -    Evita attacchi di tipo cross-site request forgery</p>";
    echo "Token: ";
    print_r($request->_token);
    echo "<br><a href='http://localhost/hw2/laravel_app/public/test'>LE FUNZIONI GET E POST SONO DIVERSE</a>";
});

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

// API Carrello
Route::get('/api/cart', [CartController::class, 'api']);
Route::match(['get', 'post'], '/api/cart/add', [CartController::class, 'add']);
Route::match(['get', 'post'], '/api/cart/remove', [CartController::class, 'remove']);

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processOrder'])->name('checkout.process');

// Profilo
Route::get('/profilo', [ProfileController::class, 'index'])->name('profilo');

// Ordini
Route::get('/ordini', [OrderController::class, 'index'])->name('ordini');
Route::get('/ordini/{id}', [OrderController::class, 'show'])->name('ordini.show');