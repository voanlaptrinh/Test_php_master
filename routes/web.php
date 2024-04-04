<?php

use App\Http\Controllers\JsonController;
use App\Http\Controllers\OrderController;
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


Route::get('/', [JsonController::class, 'index'])->name('index');
Route::get('/get-restaurants', [JsonController::class, 'getByMeal'])->name('get-restaurants');
Route::get('/get-dishes', [JsonController::class, 'getDishes'])->name('get-dishes');
// Trong routes/web.php

Route::post('/order_dishes', [OrderController::class, 'store'])->name('order_dishes');
