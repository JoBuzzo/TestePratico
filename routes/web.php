<?php

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

    Route::get('/compra/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');

    Route::get('produto/cadastrar', [ProductController::class, 'create'])->name('product.create');
    Route::post('produto/cadastrar', [ProductController::class, 'store'])->name('product.store');
});


require __DIR__ . '/auth.php';
