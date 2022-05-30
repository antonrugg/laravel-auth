<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'HomeController@index')
        ->name('home');
    });
//il middleware e' il sfotware intermedio che quando chiamiamo una determinata rotta
//ci passa attraverso e controlla l'autenticazione
//in questo caso tutti i controller che hanno Admin nel namespace
//prende tutte le rotte con il prefisso admin(gli uri della rotta) e il nome della rotta (route:list come riferimento)


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('{any?}', function () {
        return view ('guest.home');
    })->where('any', ".*");
//questa deve essere sempre l'ultima rotta
//serve a gestire tutti i percorsi al di fuori di quelli gia' gestiti
