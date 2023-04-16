<?php

// use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('item.index');
    Route::group(['middleware' => ['can:admin']], function () {
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('item.add');
        Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
        Route::get('/{item}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
        Route::post('/{item}/update', [App\Http\Controllers\ItemController::class, 'update'])->name('item.update');
        Route::delete('/{item}/delete', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.destroy');
    });
});
