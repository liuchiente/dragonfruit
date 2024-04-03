<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Line\NotifyDataController;
use App\Http\Controllers\Line\LoginController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});


/*Route::middleware('guest')->group(function () {
    //Line Login
    Route::get('login', [LoginController::class,'pageLine'])->name('login');
    Route::get('callback/linelogin', [LoginController::class,'lineLoginCallBack']);
});*/


Route::middleware('auth')->group(function () {

    //Auth
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    //Line Notify
    Route::get('add-notify-channel', [NotifyDataController::class, 'getOneChannel'])->name('notify.token.add');
    Route::get('edit-notify-channel', [NotifyDataController::class, 'getOneChannel'])->name('notify.token.edit');
    Route::post('save-notify-channel', [NotifyDataController::class, 'saveOneChannel'])->name('notify.token.save');
    Route::get('show-notify-channel', [NotifyDataController::class, 'getManyChannel'])->name('notify.token.show');
    //Route::post('share-notify-channel', [NotifyDataController::class, 'saveOneChannel'])->name('notify.token.show');

    Route::get('add-notify-template', [NotifyDataController::class, 'addOneTemplate'])->name('notify.template.add');
    Route::get('edit-notify-template', [NotifyDataController::class, 'getOneTemplate'])->name('notify.template.edit');
    Route::post('save-notify-template', [NotifyDataController::class, 'saveOneTemplate'])->name('notify.template.save');
    Route::get('show-notify-template', [NotifyDataController::class, 'getManyTemplate'])->name('notify.template.show');

    Route::get('show-notify-message', [NotifyDataController::class, 'getManyMessage'])->name('notify.message.show');

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    
    //管理後台
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




