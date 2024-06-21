<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/dashboard', [PurchaseController::class, 'index'])->name('dashboard');

    Route::get('/compra/cadastrar', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/compra/cadastrar', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('compra/{purchase}/editar', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('compra/{purchase}/editar', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('compra/{purchase}/deletar', [PurchaseController::class, 'delete'])->name('purchase.delete');

    Route::get('/compra/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');

    Route::get('produto/cadastrar', [ProductController::class, 'create'])->name('product.create');
    Route::post('produto/cadastrar', [ProductController::class, 'store'])->name('product.store');

    Route::get('cliente/cadastrar', [ClientController::class, 'create'])->name('client.create');
    Route::post('cliente/cadastrar', [ClientController::class, 'store'])->name('client.store');

    Route::get('pdf/{purchase}', PDFController::class)->name('pdf');
});


require __DIR__ . '/auth.php';
