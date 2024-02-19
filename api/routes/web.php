<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::get('/categorias', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categorias/adicionar', [CategoryController::class, 'add'])->name('category.add');
Route::post('/categorias/salvar', [CategoryController::class, 'save'])->name('category.save');
Route::get('/categorias/editar/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/categorias/editar/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/categorias/deletar/{id}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/categorias/buscar', [CategoryController::class, 'search'])->name('category.search');
Route::post('/categorias/buscar', [CategoryController::class, 'search'])->name('category.search');

Route::get('/produtos', [ProductController::class, 'index'])->name('product.index');
Route::get('/produtos/adicionar', [ProductController::class, 'add'])->name('product.add');
Route::post('/produtos/salvar', [ProductController::class, 'save'])->name('product.save');
Route::get('/produtos/editar/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/produtos/editar/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/produtos/deletar/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::post('/produtos/buscar', [ProductController::class, 'search'])->name('product.search');
Route::get('/produtos/buscar', [ProductController::class, 'search'])->name('product.search');
