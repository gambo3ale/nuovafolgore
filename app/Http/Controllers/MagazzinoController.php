<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stagione;
use App\Models\Genitore;
use App\Models\Giocatore;
use App\Models\Ricevuta;
use App\Models\LogAzione;
use App\Models\SeasonPlayer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MagazzinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$s];
            return view('dashboardMagazzino')->with('data',$data);
        }
        return redirect(route('welcome'));
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

    public function lista(Request $request)
    {
        $gio = DB::table('season_players')
        ->join('giocatores', 'giocatores.id', '=', 'season_players.id_giocatore')
        ->select('season_players.id','season_players.taglia_kit','season_players.consegna_kit','season_players.note', 'giocatores.cognome', 'giocatores.nome', 'giocatores.data_nascita')
        ->where('season_players.id_stagione', $request->id)
        ->orderBy('giocatores.cognome')
        ->get();
        return response()->json($gio, 200);
    }

    public function aggiornaNote(Request $request)
    {
        //dd($request->idc);
        $cli= SeasonPlayer::where('id',$request->idc)->update(['note'=>$request->note]);
        return response()->json( "OK", 200);
    }

    public function aggiornaTaglia(Request $request)
    {
        //dd($request->idc);

        $cli= SeasonPlayer::where('id',$request->idc)->update(['taglia_kit'=>strtoupper($request->taglia_kit)]);
        return response()->json( "OK", 200);
    }

    public function registraConsegna(Request $request)
    {
        $cli=SeasonPlayer::find($request->id);
        $cli->consegna_kit=1;
        $cli->save();
        return response()->json( "OK", 200);
    }

    public function annullaConsegna(Request $request)
    {
        $cli=SeasonPlayer::find($request->id);
        $cli->consegna_kit=0;
        $cli->save();
        return response()->json( "OK", 200);
    }
}
