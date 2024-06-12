<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Enseignantcontroller;
use App\Http\Controllers\API\Classecontroller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    //route vers le users
    Route::post('user/create',[UserController::class,'create']);
    Route::post('user/update',[UserController::class,'update']);
    Route::get('user/details',[UserController::class,'details']);
    Route::get('user/search',[UserController::class,'search']);

    //route vers l'enseignant
    Route::post('enseignant/create',[Enseignantcontroller::class,'create']);
    Route::get('enseignant/details',[Enseignantcontroller::class,'details']);
    Route::get('enseignant/search',[Enseignantcontroller::class,'search']);
    Route::post('enseignant/update',[Enseignantcontroller::class,'update']);

    //route vers la classe
    Route::post('classe/create',[Classecontroller::class,'create']);
    Route::get('classe/details',[Classecontroller::class,'details']);
    Route::get('classe/search',[Classecontroller::class,'search']);
    Route::post('classe/update',[Classecontroller::class,'update']);




 
});
Route::post('user/login',[UserController::class,'login']);