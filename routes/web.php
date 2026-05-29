<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternController;
use App\Http\Controllers\TimeLogController;

use App\Http\Controllers\SummaryController;

Route::get('/', function () {
    return redirect()->route('summary.index');
});

Route::get('/resumen', [SummaryController::class, 'index'])->name('summary.index');

Route::resource('interns', InternController::class);
Route::resource('time_logs', TimeLogController::class)->only(['store', 'update', 'destroy']);

// Rutas de Control de Horas
Route::get('time-control', [\App\Http\Controllers\TimeControlController::class, 'index'])->name('time_control.index');
Route::get('time-control/{intern}', [\App\Http\Controllers\TimeControlController::class, 'show'])->name('time_control.show');
