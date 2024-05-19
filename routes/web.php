<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/addrequest', function () {
    return view('form');
});


Route::get('/editrequest', function () {
    return view('edit');
});


Route::get('/addactions', function () {
    return view('addaction');
});

Route::get('/showrequests', function () {
    return view('show');
});

Route::get('/editactions', function () {
    return view('editact');
});

Route::get('/showresponses', function () {
    return view('showresponse');
});

