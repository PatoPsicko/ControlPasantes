<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternController;
use App\Http\Controllers\TimeLogController;

Route::get('/', function () {
    return redirect()->route('interns.index');
});

Route::resource('interns', InternController::class);
Route::resource('time_logs', TimeLogController::class)->only(['store', 'update', 'destroy']);
