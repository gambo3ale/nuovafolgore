<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Giocatore;
use App\Models\Genitore;
use App\Models\LogAzione;
use App\Models\Pagamento;
use App\Models\SeasonPlayer;
use App\Models\Ricevuta;

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
        $d=Carbon::now()->format('Y-m-d');
        $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
        if($dati['id_giocatore']!=-1)
        {
            $gio=Giocatore::find($dati['id_giocatore']);
            if($gio->id_genitore!=null)
                $gen=Genitore::find($gio->id_genitore);
            else
                $gen=new Genitore();
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
        $gio->portiere=0;


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
        $sp->taglia_kit=$dati['taglia_kit'];
        if($old!=null)
        {
            $sp->scadenza=$old->scadenza;
        }
        $sp->save();

        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Iscrizione";
        $lg->save();

        return response()->json($gio , 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $gio=Giocatore::find($id);
            $gen=Genitore::find($gio->id_genitore);
            $sp=SeasonPlayer::where('id_giocatore',$gio->id)->with('stagione')->with('pagamenti')->with('ricevute')->orderBy('id_stagione','desc')->get();
            $data=['stag'=>$s, 'gio'=>$gio, 'gen'=>$gen, 'sp'=>$sp];
            return view('giocatore.show')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function squadra($id)
    {
        if (Auth::check() )
        {
            $cat=Categoria::find($id);
            $data=['cat'=>$cat];
            return view('giocatore.squadra')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function giocatoriSquadra(Request $request)
    {
        $cat=Categoria::find($request->id);
        $sq=DB::table('season_players')
        ->join('giocatores', 'giocatores.id', '=', 'season_players.id_giocatore')
        ->where('giocatores.data_nascita','>=',$cat->inizio)
        ->where('giocatores.data_nascita','<=',$cat->fine)
        ->where('season_players.id_stagione',$cat->id_stagione)
        ->join('genitores','genitores.id','giocatores.id_genitore')
        ->select('season_players.*','giocatores.cognome','giocatores.nome','giocatores.data_nascita','giocatores.telefono','genitores.telefono as telefono_genitore')
        ->orderBy('cognome')->get();
        return response()->json($sq, 200);
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
    public function eliminaIscrizione(Request $request)
    {
        $spx=SeasonPlayer::find($request->id);
        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$spx->id_giocatore;
        $lg->id_stagione=$spx->id_stagione;
        $lg->id_season_player=$spx->id;
        $lg->azione="Iscrizione eliminata";
        $lg->save();

        $sp=SeasonPlayer::where('id',$request->id)->delete();
        $pag=Pagamento::where('id_season_player',$request->id)->delete();
        $ric=Ricevuta::where('id_season_player',$request->id)->delete();


        return response()->json("OK" , 200);
    }

    public function listaStagione(Request $request)
    {
        $gio = DB::table('season_players')
            ->join('giocatores', 'giocatores.id', '=', 'season_players.id_giocatore')
            ->leftJoin(DB::raw('(SELECT id_season_player, SUM(importo) as pagato FROM pagamentos GROUP BY id_season_player) as pagamento_sum'), function($join) {
                $join->on('pagamento_sum.id_season_player', '=', 'season_players.id');
            })
            ->select('season_players.*', 'giocatores.cognome', 'giocatores.nome', 'giocatores.data_nascita')
            ->selectRaw('YEAR(giocatores.data_nascita) as anno_nascita')
            ->selectRaw('pagamento_sum.pagato')
            ->where('season_players.id_stagione', $request->id)
            ->orderBy('anno_nascita')
            ->orderBy('cognome')
            ->get();

        return response()->json($gio, 200);
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
        $mancanti=SeasonPlayer::where('id_stagione',$s->id)->whereNull('scadenza')->count();
        $scadenza=SeasonPlayer::where('id_stagione',$s->id)->whereBetween('scadenza',[$d,$d2])->count();
        $data=['notess'=>$notess,'scaduti'=>($scaduti+$mancanti),'scadenza'=>$scadenza];
        return response()->json($data , 200);
    }

    public function modificaCertificato(Request $request)
    {
        $sp=SeasonPlayer::find($request->id);
        $d=explode('/',$request->dat);
        if($d==null)
            return response()->json("FORMATO DATA NON CORRETTO" , 200);
        $sp->scadenza=Carbon::create($d[2],$d[1],$d[0])->format('Y-m-d');
        $sp->save();

        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Certificato consegnato";
        $lg->save();
        return response()->json("CERTIFICATO REGISTRATO!" , 200);
    }

    public function modificaMatricola(Request $request)
    {
        $sp=SeasonPlayer::find($request->id);
        $sp->matricola=$request->mat;
        $sp->save();

        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Tesseramento registrato";
        $lg->save();
        return response()->json($sp , 200);
    }

    public function inserisciPagamento($id)
    {
        if (Auth::check() )
        {
            $sp=SeasonPlayer::find($id);
            $gio=Giocatore::find($sp->id_giocatore);
            $gen=Genitore::find($gio->id_genitore);
            $ric=Ricevuta::whereYear('data',Carbon::now()->format('Y'))->orderBy('numero','desc')->first();
            $num=1;
            if($ric!=null)
                $num=($ric->numero+1);
            $ut=Auth::user()->id;
            $data=['gio'=>$gio,'gen'=>$gen,'sp'=>$sp,'num'=>$num, 'ut'=>$ut];
            return view('giocatore.inserisciPagamento')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function registraPagamento(Request $request)
    {
        parse_str($request->dati, $dati);
        $pag=new Pagamento();
        $pag->id_season_player=$dati['id_season_player'];
        $pag->importo=$dati['importo'];
        $pag->tipo=$dati['tipo'];
        $pag->modalita=$dati['bonifico'];
        $pag->data=$dati['data_pagamento'];
        $pag->id_stagione=$dati['id_stagione'];
        $pag->save();

        $ric=null;
        if($dati['bonifico']!=4)
        {
            $ric=new Ricevuta();
            $ric->numero=$dati['numero'];
            $ric->data=$dati['data_ricevuta'];
            $ric->importo=$dati['importo'];
            $ric->cognome_genitore=$dati['cognome_genitore'];
            $ric->nome_genitore=$dati['nome_genitore'];
            $ric->data_genitore=$dati['data_genitore'];
            $ric->data_genitore_n=$dati['data_genitore'];
            $ric->luogo_genitore=$dati['luogo_genitore'];
            $ric->codice_genitore=$dati['codice_genitore'];
            $ric->cognome_giocatore=$dati['cognome_giocatore'];
            $ric->nome_giocatore=$dati['nome_giocatore'];
            $ric->data_giocatore_n=$dati['data_giocatore'];
            $ric->data_giocatore=$dati['data_giocatore'];
            $ric->luogo_giocatore=$dati['luogo_giocatore'];
            $ric->codice_giocatore=$dati['codice_giocatore'];
            $ric->bonifico=$dati['bonifico'];
            $ric->data_bonifico=$dati['data_pagamento'];
            $ric->intestato=$dati['intestato'];
            if($dati['tipo']=="RATA")
                $ric->tipo=0;
            if($dati['tipo']=="SALDO")
                $ric->tipo=1;
            else
                $ric->tipo=2;
            $ric->id_season_player=$dati['id_season_player'];
            $ric->id_stagione=$dati['id_stagione'];
            $ric->save();
        }

        $sp=SeasonPlayer::find($dati['id_season_player']);
        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Pagamento Registrato";
        $lg->save();

        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Emissione Ricevuta n. ".$ric->numero;
        $lg->save();
        return response()->json($ric , 200);
    }

}
