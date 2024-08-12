<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Giocatore;
use App\Models\Genitore;
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
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$s];
            return view('giocatore.create')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        parse_str($request->dati, $dati);
        $old=null;
        $gio=null;
        $gen=null;
        if($dati['id_giocatore']!=-1)
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $gio=Giocatore::find($dati['id_giocatore']);
            $gen=Genitore::find($gio->id_genitore);
            $old=SeasonPlayer::where('id_stagione',($s->id)-1)->where('id_giocatore',$gio->id)->first();
        }
        else
        {
            $gio=new Giocatore();
            $gen=new Genitore();
        }
        $gio->cognome=$dati['cognome_giocatore'];
        $gio->nome=$dati['nome_giocatore'];
        $gio->data_nascita=$dati['data_giocatore'];
        $gio->luogo_nascita=$dati['luogo_giocatore'];
        $gio->indirizzo=$dati['indirizzo_giocatore'];
        $gio->comune=$dati['comune_giocatore'];
        $gio->provincia=$dati['provincia_giocatore'];
        $gio->cap=$dati['cap_giocatore'];
        $gio->codice_fiscale=$dati['codice_giocatore'];
        $gio->telefono=$dati['telefono_giocatore'];
        $gio->email=$dati['email_giocatore'];


        $gen->cognome=$dati['cognome_genitore'];
        $gen->nome=$dati['nome_genitore'];
        $gen->data_nascita=$dati['data_genitore'];
        $gen->luogo_nascita=$dati['luogo_genitore'];
        $gen->indirizzo=$dati['indirizzo_genitore'];
        $gen->comune=$dati['comune_genitore'];
        $gen->provincia=$dati['provincia_genitore'];
        $gen->cap=$dati['cap_genitore'];
        $gen->codice_fiscale=$dati['codice_genitore'];
        $gen->telefono=$dati['telefono_genitore'];
        $gen->email=$dati['email_genitore'];
        $gen->save();

        $gio->id_genitore=$gen->id;
        $gio->save();

        $sp= new SeasonPlayer();
        $sp->id_stagione=$s->id;
        $sp->id_giocatore=$gio->id;
        $sp->iscrizione=$d;
        if($old!=null)
        {
            $sp->scadenza=$old->scadenza;
        }
        $sp->save();
        return response()->json($gio , 200);
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

    public function listaStagione(Request $request)
    {
        $gio=DB::table('season_players')
        ->join('giocatores','giocatores.id','season_players.id_giocatore')
        ->select('season_players.*','giocatores.cognome','giocatores.nome','giocatores.data_nascita')
        ->selectRaw('YEAR(giocatores.data_nascita) as anno_nascita')
        ->where('season_players.id_stagione',$request->id)
        ->orderBy('anno_nascita')->orderBy('cognome')->get();
        return response()->json($gio , 200);
    }

    public function archivioStagione(Request $request)
    {
        $gio=DB::table('season_players')
        ->join('giocatores','giocatores.id','season_players.id_giocatore')
        ->join('genitores','genitores.id','giocatores.id_genitore')
        ->select('season_players.*','giocatores.cognome','giocatores.nome','giocatores.data_nascita','giocatores.telefono','genitores.telefono as telefono_genitore')
        ->selectRaw('YEAR(giocatores.data_nascita) as anno_nascita')
        ->where('season_players.id_stagione',$request->id)
        ->orderBy('anno_nascita')->orderBy('cognome')->get();
        return response()->json($gio , 200);
    }

    public function cerca(Request $request)
    {
        $filtro = $request->filter['filters'][0];
        //dd($filtro["value"]);
        $giocatori = Giocatore::where('cognome','LIKE','%'.$filtro["value"].'%')->orWhere('codice_fiscale','LIKE','%'.$filtro["value"].'%')->get();
        //$clienti = Cliente::all();
        return response()->json($giocatori , 200);
    }

    public function ottieni(Request $request)
    {
        $d=Carbon::now()->format('Y-m-d');
        $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
        $g=Giocatore::with('genitore')->find($request->id);
        $sp=SeasonPlayer::where('id_giocatore',$g->id)->where('id_stagione',$s->id)->first();
        $data=['stag'=>$s,'gio'=>$g, 'sp'=>$sp];
        return response()->json($data , 200);
    }

    public function listaIscritti()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$s];
            return view('giocatore.listaIscritti')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function ricevuteStagione(Request $request)
    {
        $gio=DB::table('ricevutas')
        ->select('ricevutas.*')
        ->selectRaw('YEAR(ricevutas.data) as anno')
        ->where('ricevutas.id_stagione',$request->id)
        ->orderBy('anno')->orderBy('ricevutas.numero')->get();
        return response()->json($gio , 200);
    }

    public function scadenze(Request $request)
    {
        $d=Carbon::now()->format('Y-m-d');
        $d2=Carbon::now()->addDays(30)->format('Y-m-d');
        $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();

        $notess=SeasonPlayer::where('id_stagione',$s->id)->whereNull('matricola')->count();
        $scaduti=SeasonPlayer::where('id_stagione',$s->id)->where('scadenza','<',$d)->count();
        $scadenza=SeasonPlayer::where('id_stagione',$s->id)->whereBetween('scadenza',[$d,$d2])->count();
        $data=['notess'=>$notess,'scaduti'=>$scaduti,'scadenza'=>$scadenza];
        return response()->json($data , 200);
    }

    public function modificaCertificato(Request $request)
    {
        $sp=SeasonPlayer::find($request->id);
        $sp->scadenza=Carbon::parse($request->dat)->format('Y-m-d');
        $sp->save();
        return response()->json($sp , 200);
    }

    public function modificaMatricola(Request $request)
    {
        $sp=SeasonPlayer::find($request->id);
        $sp->matricola=$request->mat;
        $sp->save();
        return response()->json($sp , 200);
    }

}
