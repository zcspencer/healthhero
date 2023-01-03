<?php

use App\Http\Controllers\Registry\RegistryController;
use Illuminate\Support\Facades\Route;

Route::get('/lookup', [RegistryController::class, 'lookup']);
