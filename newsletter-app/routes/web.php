<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterSubscriberController;

Route::get('/', function () {
    return redirect('/signup');
})->name('home');
Route::get('/signup', [NewsletterSubscriberController::class, 'showSignupForm']);
Route::post('/signup', [NewsletterSubscriberController::class, 'processSignup']);

Route::get('/unsubscribe/{id}', [NewsletterSubscriberController::class, 'unsubscribe'])->name('unsubscribe');

Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_img()]);
});
