<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationAcceptanceController;


use App\Http\Controllers\ShortUrlController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{shortUrl}', [RedirectController::class, 'show'])
    ->where('shortUrl', '[A-Za-z0-9]{8}')
    ->name('short-url.redirect');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/urls', [ShortUrlController::class, 'index'])->name('urls.index');
    Route::get('/urls/create', [ShortUrlController::class, 'create'])
     ->middleware('can:create,App\Models\ShortUrl') ->name('urls.create');
    Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');
    Route::get('/invitations/create',[InvitationController::class,'create'])
    ->middleware('can:create-invitation')->name('invitations.create');
    Route::post('/invitations',[InvitationController::class,'store'])->name('invitations.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/invitations/{token}',[InvitationAcceptanceController::class,'Show'])->name('invitations.show');
Route::post('/invitations/{token}',[InvitationAcceptanceController::class,'Store'])->name('invitations.accept');



require __DIR__.'/auth.php';
