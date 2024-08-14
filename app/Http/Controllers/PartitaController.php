<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Giocatore;
use App\Models\Squadra;
use App\Models\Campo;
use App\Models\Partita;

class PartitaController extends Controller
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
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $cat=Categoria::where('id_stagione',$s->id)->get();
            $data=['stag'=>$s, 'cat'=>$cat];
            return view('partita.create')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function cercaAvversario(Request $request)
    {
        $filtro = $request->filter['filters'][0];
        //dd($filtro["value"]);
        $giocatori = Squadra::where('nome','LIKE','%'.$filtro["value"].'%')->get();
        //$clienti = Cliente::all();
        return response()->json($giocatori , 200);
    }

    public function cercaCampo(Request $request)
    {
        $filtro = $request->filter['filters'][0];
        //dd($filtro["value"]);
        $giocatori = Campo::where('titolo','LIKE','%'.$filtro["value"].'%')->orWhere('abbreviato','LIKE','%'.$filtro["value"].'%')->get();
        //$clienti = Cliente::all();
        return response()->json($giocatori , 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        parse_str($request->dati, $dati);
        //dd($dati);
        $c=Partita::create($dati);
        return response()->json($c , 200);
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
