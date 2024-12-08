<?php

use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    Mail::to('muhnurulmustofa@gmail.com')->send(new HelloMail());
    // return view('welcome');
});
