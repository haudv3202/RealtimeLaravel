<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Chat\ChatController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/users','users.showsAll')->name('users.shows');
Route::view('/game','game.show')->name('game.show');
Route::get('/chat',[ChatController::class,"index"])->name('chat');
Route::post('/chat/message',[ChatController::class,"messageSent"])->name('chat.sent');
Route::post('/chat/greet/{user}',[ChatController::class,"greetRecevied"])->name('chat.sent');
