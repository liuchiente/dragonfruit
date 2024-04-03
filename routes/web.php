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
    return view('welcome');
});

//line card share callback
Route::get('/endpoint', function () {
    return view('cano.liff-full.index');
});

Route::get('/endpoint/share-json5gzip', function () {
    return view('cano.liff-full.share-json5gzip');
});

require __DIR__.'/auth.php';
