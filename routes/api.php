<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Line\LineApiController;
use App\Http\Controllers\API\TestController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('bob/line', [LineApiController::class, 'alive'])->name('line.alive');
Route::post('bob/line', [LineApiController::class, 'bob'])->name('line.bob');


Route::get('test/category', [TestController::class, 'category'])->name('test.category');
Route::get('test/cart', [TestController::class, 'cart'])->name('test.cart');
Route::get('test/message', [TestController::class, 'message'])->name('test.message');
Route::get('test/notification', [TestController::class, 'notification'])->name('test.notification');
Route::get('test/product', [TestController::class, 'product'])->name('test.product');
Route::get('test/search', [TestController::class, 'search'])->name('test.search');
Route::get('test/popular', [TestController::class, 'popular'])->name('test.popular');
Route::get('test/news', [TestController::class, 'news'])->name('test.news');
