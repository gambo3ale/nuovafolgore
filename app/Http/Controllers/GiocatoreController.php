<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Giocatore;
use App\Models\SeasonPlayer;

class GiocatoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listaStagione()
    {
        $gio=DB::table('season_players')
        ->join('giocatores','giocatores.id','season_players.id_giocatore')
        ->select('season_players.*','giocatores.cognome','giocatores.nome','giocatores.data_nascita')
        ->selectRaw('YEAR(giocatores.data_nascita) as anno_nascita')
        ->where('season_players.id_stagione',6)
        ->orderBy('anno_nascita')->orderBy('cognome')->get();
        return response()->json($gio , 200);
    }
}
