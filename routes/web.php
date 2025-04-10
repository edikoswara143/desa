<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('pages.home');
// });

Route::get('/', App\Livewire\Home\Index::class)->name('home.index');
