<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiocatoreController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GamboController;
use App\Http\Controllers\PartitaController;
use App\Http\Controllers\StaffController;



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
Route::post('/giocatore/registraPagamento', [GiocatoreController::class,'registraPagamento'])->name('giocatore.registraPagamento');
Route::post('/giocatore/eliminaIscrizione', [GiocatoreController::class,'eliminaIscrizione'])->name('giocatore.eliminaIscrizione');
Route::post('/giocatore/giocatoriSquadra', [GiocatoreController::class,'giocatoriSquadra'])->name('giocatore.giocatoriSquadra');

Route::post('/admin/modificaRicevuta', [AdminController::class,'modificaRicevuta'])->name('admin.modificaRicevuta');
Route::post('/admin/getCategorie', [AdminController::class,'getCategorie'])->name('admin.getCategorie');

Route::get('/partita/cercaAvversario', [PartitaController::class,'cercaAvversario'])->name('partita.cercaAvversario');
Route::get('/partita/cercaCampo', [PartitaController::class,'cercaCampo'])->name('partita.cercaCampo');
Route::post('/partita/store', [PartitaController::class,'store'])->name('partita.store');
Route::post('/partita/update', [PartitaController::class,'update'])->name('partita.update');
Route::get('/partita/getPartite', [PartitaController::class,'getPartite'])->name('partita.getPartite');


Route::post('/document/moduloIscrizione', [DocumentController::class,'moduloIscrizione'])->name('document.moduloIscrizione');
Route::post('/document/stampaRicevuta', [DocumentController::class,'stampaRicevuta'])->name('document.stampaRicevuta');

Route::post('/gambo/visualizzaLog', [GamboController::class,'visualizzaLog'])->name('gambo.visualizzaLog');
Route::post('/gambo/visualizzaCampi', [GamboController::class,'visualizzaCampi'])->name('gambo.visualizzaCampi');
Route::post('/gambo/salvaCampo', [GamboController::class,'salvaCampo'])->name('gambo.salvaCampo');
Route::post('/gambo/visualizzaSquadre', [GamboController::class,'visualizzaSquadre'])->name('gambo.visualizzaSquadre');
Route::post('/gambo/salvaSquadra', [GamboController::class,'salvaSquadra'])->name('gambo.salvaSquadra');

Route::post('/staff/listaStagione', [StaffController::class,'listaStagione'])->name('staff.listaStagione');
Route::post('/staff/eliminaIscrizione', [StaffController::class,'eliminaIscrizione'])->name('staff.eliminaIscrizione');
Route::post('/staff/store', [StaffController::class,'store'])->name('staff.store');
Route::post('/staff/memorizza', [StaffController::class,'memorizza'])->name('staff.memorizza');
