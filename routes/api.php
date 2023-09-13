<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'cart'], function () {
  //GET /cart
  Route::get('/', [CartController::class,'index']);
  //POST /cart/add/{item}
  Route::post('/add/{item}',[CartController::class,'add']);
  //PUT /cart
  Route::put('/', [CartController::class,'update']);
  //PATCH /cart/item/{item-id}/qty/1
  Route::patch('/item/{item}/{attribute}/{value}', [CartController::class,'updateItem']);
  //PATCH /cart/shipping/{shipping-id}
  Route::patch('/shipping/{shipping}', [CartController::class,'updateShipping']);
  //DELETE /cart/{item}
  Route::delete('/{item}', [CartController::class,'remove']);
});


Route::group(['prefix' => 'checkout'], function () {
  // GET /checkout
  Route::get('/',  [CheckoutController::class,'index']);
  // PATCH /checkout/payment-method/{id}/{condicao}
  Route::patch('/payment-method/{id}/{condition}', [CheckoutController::class,'updatePaymentMethod']);
  // POST /checkout (executa pagamento)
  Route::post('/', [CheckoutController::class,'checkout']);
});