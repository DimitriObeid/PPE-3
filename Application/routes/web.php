<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\FournituresController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ServiceController;

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

Route::get('/', function () {
    return view('connexion');
});

Route::post('/connexion', [PersonnelController::class, 'connexion']);

Route::get('/inscription', [PersonnelController::class, 'creer']);

Route::post('/inscription', [PersonnelController::class, 'verif_creer']);

Route::get('/deconnexion', [PersonnelController::class, 'deconnexion']);

Route::get('/accueil', [PersonnelController::class, 'accueil']);

Route::post('/message', [PersonnelController::class, 'message']);

Route::post('/supprimer', [PersonnelController::class, 'supprimer']);
