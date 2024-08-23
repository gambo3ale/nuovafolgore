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
use App\Models\SquadraAllenata;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AllenatoreController extends Controller
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
            return view('allenatore.index')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function squadra($id)
    {
        if (Auth::check() )
        {
            $cat=Categoria::find($id);
            $data=['cat'=>$cat];
            return view('allenatore.squadra')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCategorie(Request $request)
    {
        $d=Carbon::now()->format('Y-m-d');
        $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
        $sq=SquadraAllenata::with('categoria')->where('id_utente',$request->id)->where('id_stagione',$s->id)->get();
        return response()->json($sq , 200);
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
}
