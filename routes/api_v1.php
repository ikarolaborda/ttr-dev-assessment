<?php

use App\Http\Controllers\Api\v1\CSVController;
use Illuminate\Support\Facades\Route;

Route::post(
    'compare-csv',
    [CSVController::class, 'compare']
)->name('compare-csv');
