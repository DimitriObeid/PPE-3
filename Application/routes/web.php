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

Route::post('/modificationlogo', [PersonnelController::class, 'modificationlogo']);

Route::post('/suppressionlogo', [PersonnelController::class, 'suppressionlogo']);

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

// Gestion des commandes
Route::get('/suivi', [CommandesController::class, 'afficher']);

Route::post('/commander', [CommandesController::class, 'commander']);

// Gestion des d'états
Route::post('/majetatdemande', [EtatController::class, 'majetatdemande']);

Route::post('/majetatcommande', [EtatController::class, 'majetatcommande']);

// Gestion des départements
Route::get('/departements', [ServiceController::class, 'afficher']);
