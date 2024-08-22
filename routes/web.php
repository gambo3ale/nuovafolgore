<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GiocatoreController;
use App\Http\Controllers\GamboController;
use App\Http\Controllers\PartitaController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::group(['middleware' => ['role:user','auth']], function () {
    Route::get('/dashboard', [AdminController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
});

Route::group(['middleware' => ['role:segreteria','auth']], function () {

Route::get('/admin/archivioIscritti', [AdminController::class,'archivioIscritti'])->middleware(['auth', 'verified'])->name('admin.archivioIscritti');
Route::get('/admin/archivioRicevute', [AdminController::class,'archivioRicevute'])->middleware(['auth', 'verified'])->name('admin.archivioRicevute');
Route::get('/admin/listaRicevute', [AdminController::class,'listaRicevute'])->middleware(['auth', 'verified'])->name('admin.listaRicevute');
Route::get('/admin/allinea', [AdminController::class,'allinea'])->middleware(['auth', 'verified'])->name('admin.allinea');
Route::get('/admin/allineaDate', [AdminController::class,'allineaDate'])->middleware(['auth', 'verified'])->name('admin.allineaDate');

Route::get('/giocatore/create', [GiocatoreController::class,'create'])->middleware(['auth', 'verified'])->name('giocatore.create');
Route::get('/giocatore/show/{id}', [GiocatoreController::class,'show'])->middleware(['auth', 'verified'])->name('giocatore.show');
Route::get('/giocatore/squadra/{id}', [GiocatoreController::class,'squadra'])->middleware(['auth', 'verified'])->name('giocatore.squadra');
Route::get('/giocatore/listaIscritti', [GiocatoreController::class,'listaIscritti'])->middleware(['auth', 'verified'])->name('giocatore.listaIscritti');
Route::get('/giocatore/inserisciPagamento/{id}', [GiocatoreController::class,'inserisciPagamento'])->middleware(['auth', 'verified'])->name('giocatore.inserisciPagamento');

Route::get('/partita/create', [PartitaController::class,'create'])->middleware(['auth', 'verified'])->name('partita.create');
Route::get('/partita/calendario', [PartitaController::class,'calendario'])->middleware(['auth', 'verified'])->name('partita.calendario');

Route::get('/staff/create', [StaffController::class,'create'])->middleware(['auth', 'verified'])->name('staff.create');
Route::get('/staff/index', [StaffController::class,'index'])->middleware(['auth', 'verified'])->name('staff.index');
Route::get('/staff/registra', [StaffController::class,'registra'])->middleware(['auth', 'verified'])->name('staff.registra');
});

Route::group(['middleware' => ['role:admin','auth']], function () {
Route::get('gambo/index', [GamboController::class,'index'])->middleware(['auth', 'verified'])->name('gambo.index');
Route::get('gambo/campi', [GamboController::class,'campi'])->middleware(['auth', 'verified'])->name('gambo.campi');
Route::get('gambo/roles', [GamboController::class, 'roles'])->name('gambo.roles');
Route::post('gambo/roles/add', [GamboController::class, 'addRole'])->name('roles.add');
Route::post('gambo/roles/remove', [GamboController::class, 'removeRole'])->name('roles.remove');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-middleware', function () {
    // Codice di test
})->middleware([\App\Http\Middleware\UpdateUserActivity::class, 'auth']);

Route::get('/check-auth', function () {
    if (Auth::check()) {
        return 'Authenticated user ID: ' . Auth::id();
    }
    return 'User is not authenticated';
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [GamboController::class, 'index'])->name('admin.dashboard');
});

Route::get('/test-user-activity', function () {
    return 'Testing User Activity Middleware';
})->middleware([\App\Http\Middleware\UpdateUserActivity::class, 'auth']);

require __DIR__.'/auth.php';
