<?php

use Illuminate\Http\Request;

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

Route::prefix('bpo')->group(function () {
    Route::group(['middleware' => 'auth:bpoapi'], function () {
        Route::post('change-order-status', 'bpo\bpoapi\BpoApiController@change_order_status');
        Route::post('lp-order-track-message', 'bpo\bpoapi\BpoApiController@save_order_tracking_message');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('checkout','CheckoutController@index');

// partner UDC API
Route::post('login', 'api\ApiController@login');
Route::get('auth-check/{token}', 'partnerController@go_to_ekom');
Route::get('get-info', 'partnerController@get_info');
Route::get('auth-check-test/{token}', 'partnerController@go_to_ekom2');

//EP API
//Route::post('pl-xhr/add-to-cart', 'Frontend\CartController@add_to_cart');
Route::post('create-ep-session', 'api\EpApiController@create_ep_session');
Route::post('ep-change-order-status', 'api\EpApiController@change_order_status');
Route::post('set-cart', 'api\EpApiController@set_cart');
Route::post('ep-orders', 'api\EpApiController@orders');

// LP API
Route::post('change-order-status', 'api\LpApiController@change_order_status');
Route::post('lp-order-track-message', 'api\LpApiController@save_order_tracking_message');
Route::post('lp-orders', 'api\LpApiController@orders');
