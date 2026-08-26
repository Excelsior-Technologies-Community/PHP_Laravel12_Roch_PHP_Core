<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/lang/{lang}', [UserController::class, 'switchLanguage'])
    ->name('lang.switch');

Route::get('/theme/toggle', [UserController::class, 'toggleTheme'])
    ->name('theme.toggle');

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])
    ->name('users.edit');

Route::post('/users/{id}', [UserController::class, 'update'])
    ->name('users.update');

Route::get('/users/{id}/delete', [UserController::class, 'destroy'])
    ->name('users.delete');

Route::get('/users/export/csv', [UserController::class, 'exportCSV'])
    ->name('users.export.csv');

Route::get('/users/export/excel', [UserController::class, 'exportExcel'])
    ->name('users.export.excel');

Route::get('/users/export/pdf', [UserController::class, 'exportPDF'])
    ->name('users.export.pdf');

Route::get('/users/print', [UserController::class, 'printView'])
    ->name('users.print');
