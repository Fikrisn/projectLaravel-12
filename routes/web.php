<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/items');

Route::resource('items', ItemController::class)->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);
Route::post('/items/{item}/movements', [StockMovementController::class, 'store'])->name('items.movements.store');
