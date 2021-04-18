<?php

use Illuminate\Http\Request;
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

//
// account
//
Route::post('/login', 'Api\AuthController@login');
Route::post('/regUser', 'Api\AuthController@regUser');
Route::get('/forgot', 'Api\AuthController@forgot');
Route::post('/changePassword', 'Api\AuthController@changePassword')->middleware('auth:api');
Route::post('/changeProfile', 'Api\AuthController@changeProfile')->middleware('auth:api');
Route::post('/uploadAvatar', 'Api\AuthController@uploadAvatar')->middleware('auth:api');

Route::get('getfaq', 'Api\BaseController@getFaq');
Route::get('getMain', 'Api\RestaurantsController@getMain');

//
// Restaurant details information
//
Route::get('getRestaurant', 'Api\RestaurantsController@getRestaurant');
Route::post('getFoods', 'Api\RestaurantsController@getFoods');

Route::post('/addToBasket', 'Api\OrdersController@addToBasket')->middleware('auth:api');
Route::post('/resetBasket', 'Api\OrdersController@resetBasket')->middleware('auth:api');
Route::post('/getBasket', 'Api\OrdersController@getBasket')->middleware('auth:api');
Route::post('/deleteFromBasket', 'Api\OrdersController@deleteFromBasket')->middleware('auth:api');
Route::post('/setCountInBasket', 'Api\OrdersController@setCountInBasket')->middleware('auth:api');

Route::get('/search', 'Api\SearchController@search');
Route::get('/category', 'Api\CategoryController@get');

//
// orders
//
Route::post('/getOrders', 'Api\OrdersController@getOrders')->middleware('auth:api');

//
// notifications
//
Route::post('/fcbToken', 'Api\AuthController@fcbToken')->middleware('auth:api');
Route::get('/notify', 'Api\NotifyController@get')->middleware('auth:api');
Route::post('/notifyDelete', 'Api\NotifyController@delete')->middleware('auth:api');

//
// chat
//
Route::get('/chatUsers2', 'ChatController@chatUsersApi')->middleware('auth:api');
Route::get('/chatMessages2', 'ChatController@getChatMessages')->middleware('auth:api');
Route::post('/chatMessageSend2', 'ChatController@chatNewMessageApi')->middleware('auth:api');
//
// favorites
//
Route::get('/favoritesGet', 'Api\FavoritesController@get')->middleware('auth:api');
Route::post('/favoritesAdd', 'Api\FavoritesController@add')->middleware('auth:api');
Route::post('/favoritesDelete', 'Api\FavoritesController@delete')->middleware('auth:api');

//
// reviews
//
Route::post('/foodReviewsAdd', 'Api\ReviewsController@foodAdd')->middleware('auth:api');
Route::post('/restaurantReviewsAdd', 'Api\ReviewsController@restaurantAdd')->middleware('auth:api');

//
// driver app
//
Route::post('/setStatus', 'Api\DriverController@setStatus')->middleware('auth:api');
Route::post('/getStatus', 'Api\DriverController@getStatus')->middleware('auth:api');
Route::get('/getDriverOrders', 'Api\DriverController@getDriverOrders')->middleware('auth:api');
Route::post('/reject', 'Api\DriverController@reject')->middleware('auth:api');
Route::post('/accept', 'Api\DriverController@accept')->middleware('auth:api');
Route::post('/complete', 'Api\DriverController@complete')->middleware('auth:api');
Route::get('/getStatistics', 'Api\DriverController@getStatistics')->middleware('auth:api');
Route::post('/settings', 'Api\DriverController@settings');

// curbside pickup
Route::post('/arrived', 'Api\CurbsidePickupController@arrived')->middleware('auth:api');

// wallet
Route::post('/walletgb', 'Api\WalletController@walletGetBalans')->middleware('auth:api');
Route::post('/walletTopUp', 'Api\WalletController@walletTopUp')->middleware('auth:api');
Route::post('/payOnWallet', 'Api\WalletController@payOnWallet')->middleware('auth:api');
Route::post('/walletSetId', 'Api\WalletController@walletSetId')->middleware('auth:api');


//
// OWNER APP
//
Route::post('/uploadImage', 'Api\owner\OwnerController@uploadImage')->middleware('auth:api');
Route::post('/totals', 'Api\owner\OwnerController@totals')->middleware('auth:api');
Route::get('/getAppSettings', 'Api\owner\OwnerController@getAppSettings');
// category
Route::post('/categoryList', 'Api\owner\CategoryController@load')->middleware('auth:api');
Route::post('/categorySave', 'Api\owner\CategoryController@categorySave')->middleware('auth:api');
Route::post('/categoryDelete', 'Api\owner\CategoryController@categoryDelete')->middleware('auth:api');
// foods
Route::post('/foodsList', 'Api\owner\FoodsController@load')->middleware('auth:api');
Route::post('/foodSave', 'Api\owner\FoodsController@foodSave')->middleware('auth:api');
Route::post('/foodDelete', 'Api\owner\FoodsController@foodDelete')->middleware('auth:api');
// extras group
Route::post('/extrasGroupSave', 'Api\owner\ExtrasController@extrasGroupSave')->middleware('auth:api');
Route::post('/extrasGroupDelete', 'Api\owner\ExtrasController@extrasGroupDelete')->middleware('auth:api');
// extras
Route::post('/extrasList', 'Api\owner\ExtrasController@extrasList')->middleware('auth:api');
Route::post('/extrasSave', 'Api\owner\ExtrasController@extrasSave')->middleware('auth:api');
Route::post('/extrasDelete', 'Api\owner\ExtrasController@extrasDelete')->middleware('auth:api');
// restaurants
Route::post('/restaurantsList', 'Api\owner\RestaurantsController@restaurantsRet')->middleware('auth:api');
Route::post('/restaurantSave', 'Api\owner\RestaurantsController@restaurantsSave')->middleware('auth:api');
// orders
Route::post('/ordersList', 'Api\owner\OwnerOrdersController@ordersList')->middleware('auth:api');
Route::post('/changeStatus', 'Api\owner\OwnerOrdersController@changeStatus')->middleware('auth:api');
Route::post('/changeDriver', 'Api\owner\OwnerOrdersController@changeDriver')->middleware('auth:api');
// chat
Route::get('/getChatUnread', 'ChatController@getChatMessagesNewCount')->middleware('auth:api');
Route::get('/chatUsers', 'ChatController@chatNewUsers')->middleware('auth:api');
Route::get('/chatMessages', 'ChatController@chatMessages')->middleware('auth:api');
Route::post('/chatMessageSend', 'ChatController@chatNewMessageApi')->middleware('auth:api');

// banners and categories
Route::get('getSecondStep', 'Api\RestaurantsController@getSecondStep');

// documents
Route::get('getDocuments', 'Api\DocumentsController@getDocuments');

// address
Route::post('getAddress', 'Api\AddressController@get')->middleware('auth:api');
Route::post('saveAddress', 'Api\AddressController@save')->middleware('auth:api');
Route::post('delAddress', 'Api\AddressController@del')->middleware('auth:api');

// location
Route::post('sendLocation', 'Api\LocationController@sendLocation')->middleware('auth:api');
Route::post('getDriverLocation', 'Api\LocationController@getDriverLocation');
