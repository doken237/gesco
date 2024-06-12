<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Enseignantcontroller;
use App\Http\Controllers\API\Classecontroller;
use App\Http\Controllers\API\Etudiantcontroller;
use App\Http\Controllers\API\Notecontoller;
use App\Http\Controllers\API\Matierecontroller;
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

    //route vers l'etudiant
    Route::post('etudiant/create',[Etudiantcontroller::class,'create']);
    Route::get('etudiant/details',[Etudiantcontroller::class,'details']);
    Route::get('etudiant/search',[Etudiantcontroller::class,'search']);
    Route::post('etudiant/update',[Etudiantcontroller::class,'update']);

    //route vers les note
    Route::post('note/create',[Notecontoller::class,'create']);

    //route vers les matiere
    Route::post('matiere/create',[Matierecontroller::class,'create']);
    Route::post('matiere/update',[Matierecontroller::class,'update']);
    Route::get('matiere/details',[Matierecontroller::class,'details']);
    Route::get('matiere/search',[Matierecontroller::class,'search']);

    




 
});
Route::post('user/login',[UserController::class,'login']);