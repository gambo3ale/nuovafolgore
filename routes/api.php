<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiocatoreController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/giocatore/listaStagione', [GiocatoreController::class,'listaStagione'])->name('giocatore.listaStagione');
Route::post('/giocatore/ricevuteStagione', [GiocatoreController::class,'ricevuteStagione'])->name('giocatore.ricevuteStagione');
Route::post('/giocatore/archivioStagione', [GiocatoreController::class,'archivioStagione'])->name('giocatore.archivioStagione');
Route::get('/giocatore/cerca', [GiocatoreController::class,'cerca'])->name('giocatore.cerca');
Route::post('/giocatore/ottieni', [GiocatoreController::class,'ottieni'])->name('giocatore.ottieni');
Route::post('/giocatore/store', [GiocatoreController::class,'store'])->name('giocatore.store');
Route::post('/giocatore/scadenze', [GiocatoreController::class,'scadenze'])->name('giocatore.scadenze');
Route::post('/giocatore/modificaCertificato', [GiocatoreController::class,'modificaCertificato'])->name('giocatore.modificaCertificato');
Route::post('/giocatore/modificaMatricola', [GiocatoreController::class,'modificaMatricola'])->name('giocatore.modificaMatricola');

Route::post('/admin/modificaRicevuta', [AdminController::class,'modificaRicevuta'])->name('admin.modificaRicevuta');

Route::post('/document/moduloIscrizione', [DocumentController::class,'moduloIscrizione'])->name('document.moduloIscrizione');
