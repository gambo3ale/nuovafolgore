<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiocatoreController;
use App\Http\Controllers\DocumentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/giocatore/listaStagione', [GiocatoreController::class,'listaStagione'])->name('giocatore.listaStagione');
Route::post('/giocatore/archivioStagione', [GiocatoreController::class,'archivioStagione'])->name('giocatore.archivioStagione');
Route::get('/giocatore/cerca', [GiocatoreController::class,'cerca'])->name('giocatore.cerca');
Route::post('/giocatore/ottieni', [GiocatoreController::class,'ottieni'])->name('giocatore.ottieni');
Route::post('/giocatore/store', [GiocatoreController::class,'store'])->name('giocatore.store');

Route::post('/document/moduloIscrizione', [DocumentController::class,'moduloIscrizione'])->name('document.moduloIscrizione');
