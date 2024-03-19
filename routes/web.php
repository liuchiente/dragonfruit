<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Line\LineCardController;
use App\Http\Controllers\Line\LoginController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//line card share callback
Route::get('/endpoint', function () {
    return view('cano.liff-full.index');
});

Route::get('/endpoint/share-json5gzip', function () {
    return view('cano.liff-full.share-json5gzip');
});


Route::middleware('guest')->group(function () {
    //Line Login
    Route::get('login', [LoginController::class,'pageLine'])->name('login');
    Route::get('callback/linelogin', [LoginController::class,'lineLoginCallBack']);
});


Route::middleware('auth')->group(function () {

    Route::get('templates', [LineCardController::class,'templatesShow'])->name('line.templates.get');
    Route::get('cards', [LineCardController::class,'cardsShow'])->name('line.cards.get');

    Route::get('template', [LineCardController::class,'template'])->name('line.template.get');
    Route::post('template', [LineCardController::class,'templateStore'])->name('line.card.template.store');
    Route::get('card', [LineCardController::class,'card'])->name('line.card.get');
    Route::post('card', [LineCardController::class,'cardStore'])->name('line.card.store');

    //多頁訊息模板
    Route::get('/designer/carousel-1', [LineCardController::class,'carousel1'])->name('line.card.carousel1');
    Route::get('/designer/cv-1', [LineCardController::class,'cv1'])->name('line.card.cv1');
    
});


require __DIR__.'/auth.php';
