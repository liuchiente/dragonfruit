<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Line\LineCardController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->to('login');
    //return view('welcome');
});

//line card share callback
Route::get('/endpoint', function () {
    return view('cano.liff-full.index');
});

Route::get('/endpoint/share-json5gzip', function () {
    return view('cano.liff-full.share-json5gzip');
});

Route::get('/endpoint/share-j5gz', function () {
    return view('line.share-j5gz');
});


Route::get('/endpoint/binding', function () {
    return view('line.binding');
});

Route::get('/endpoint/shop-products', function () {
    return view('shop.products');
});

Route::get('/endpoint/shop-cart', function () {
    return view('shop.cart');
});

Route::get('/endpoint/shop-product', function () {
    return view('shop.product');
});

Route::get('/endpoint/shop-checkout', function () {
    return view('shop.checkout');
});

require __DIR__.'/auth.php';
