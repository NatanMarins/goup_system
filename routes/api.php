<?php

use App\Http\Controllers\Api\TomadorApiController;
use App\Http\Controllers\TomadorServicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/tomadores', [TomadorApiController::class, 'indexApi']);
Route::post('/tomadores', [TomadorApiController::class, 'storeApi']);



Route::post('/customers', [TomadorServicoController::class, 'createCustomer']);
Route::get('/buscar-cliente', [TomadorServicoController::class, 'getCustomerByCpfCnpj'])->name('buscar.cliente');