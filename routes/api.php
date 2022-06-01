<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[AuthController::class,'login']);
Route::post('/Clientregister',[AuthController::class , 'Clientregister']);
Route::post('/Agenceregister',[AuthController::class , 'Agenceregister']);
Route::get('/hhhh',[OfferController::class,'hhhh']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/getimages/{filename}',[OfferController::class,'getimages']);
    Route::get('/getDetailoffer/{id}',[OfferController::class,'getDetailoffer']);
    Route::delete('/logout',[AuthController::class , 'logout']);
    Route::get('/clientinfo',[UserController::class,'clientinfo']);
    Route::get('/agenceinfo',[UserController::class,'agenceinfo']);
    Route::post('/updateagence/{email}',[UserController::class,'updateagenceinfo']);
    Route::post('/updateclient/{email}',[UserController::class,'updateclientinfo']);
    Route::get('/getoffer',[OfferController::class , 'getoffer']);
    Route::get('/Highprice',[OfferController::class , 'Highprice']);
    Route::get('/Lowprice',[OfferController::class , 'Lowprice']);
    Route::get('/Highsurface',[OfferController::class , 'Highsurface']);
    Route::get('/Lowsurface',[OfferController::class , 'Lowsurface']);
    Route::get('/Oldoffer',[OfferController::class , 'Oldoffer']);
    Route::get('/Newoffer',[OfferController::class , 'Newoffer']);
    Route::get('/getagenceoffer',[OfferController::class , 'getagenceoffer']);
    Route::get('/getCategories',[OfferController::class , 'getCategories']);
    Route::post('/addoffer',[OfferController::class , 'addoffer']);
    Route::post('/addcomment',[OfferController::class , 'addcomment']);
    Route::get('/getcomments/{id}',[OfferController::class , 'getcomments']);
    Route::delete('/deleteoffer/{id}',[OfferController::class , 'deleteoffer']);
    Route::post('/addvue/{id}',[OfferController::class , 'addvue']);
    Route::get('/getvues/{id}',[OfferController::class , 'getvues']);
    Route::post('/addfavorite/{id}',[FavoriteController::class,'addfavorite']);
    Route::get('/existefavorite/{id}',[FavoriteController::class,'existefavorite']);
    Route::get('/listfavorite',[FavoriteController::class,'listfavorite']);
    Route::post('/updatepassword',[UserController::class,'updatepassword']);
    Route::post('/editoffer/{id}',[OfferController::class,'editoffer']);
    Route::get('/getfileimage',[OfferController::class,'getfileimage']);
    Route::get('/search',[SearchController::class,'search']);
    Route::get('/agenceverification',[AuthController::class,'agenceverification']);
}
);
