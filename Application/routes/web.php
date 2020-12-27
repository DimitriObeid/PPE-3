<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\DemandesSpecifiquesController;
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

// Page d'accueil
Route::get('/', function () {
    return view('connexion');
});

// Gestion du personnel
Route::post('/connexion', [PersonnelController::class, 'connexion']);

Route::get('/inscription', [PersonnelController::class, 'creer']);

Route::post('/inscription', [PersonnelController::class, 'verif_creer']);

Route::get('/deconnexion', [PersonnelController::class, 'deconnexion']);

Route::get('/accueil', [PersonnelController::class, 'afficher']);

Route::post('/message', [PersonnelController::class, 'message']);

Route::post('/supprimer', [PersonnelController::class, 'supprimer']);

Route::get('/messagerie', [PersonnelController::class, 'messagerie']);

Route::get('/statistique', [PersonnelController::class, 'statistique']);

Route::get('/personnalisationducompte', [PersonnelController::class, 'personnalisationducompte']);

// Gestion des fournitures
Route::get('/fournitures', [FournituresController::class, 'afficher']);

Route::post('/rechercher', [FournituresController::class, 'rechercher']);

Route::post('/creationfourniture', [FournituresController::class, 'creationfourniture']);

Route::post('/majquantite', [FournituresController::class, 'majquantite']);

// Gestion des demandes spécifiques
Route::get('/demandesspecifiques', [DemandesSpecifiquesController::class, 'afficher']);

Route::post('/creationdemande', [DemandesSpecifiquesController::class, 'creation']);

// Gestion des d'états
Route::get('/suivi', [EtatController::class, 'afficher']);

Route::post('/majetatdemande', [EtatController::class, 'majetatdemande']);

// Gestion des départements
Route::get('/departements', [ServiceController::class, 'afficher']);
