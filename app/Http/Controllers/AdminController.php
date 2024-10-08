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

class AdminController extends Controller
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
            return view('dashboard')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function archivioIscritti()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $stag=Stagione::orderBy('id','desc')->get();
            $cor=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$stag,'cor'=>$cor];
            return view('admin.archivioIscritti')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function archivioRicevute()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $stag=Stagione::orderBy('id','desc')->get();
            $cor=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$stag,'cor'=>$cor];
            return view('admin.archivioRicevute')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function listaRicevute()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $stag=Stagione::orderBy('id','desc')->get();
            $cor=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $data=['stag'=>$stag,'cor'=>$cor];
            return view('admin.listaRicevute')->with('data',$data);
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
    public function modificaRicevuta(Request $request)
    {
        $r=Ricevuta::find($request->id);
        $r->numero=$request->num;
        $r->data=$request->dataR;
        $r->data_bonifico=$request->dataB;
        $r->save();

        $sp=SeasonPlayer::find($r->id_season_player);
        $lg=new LogAzione();
        $lg->id_utente=$request->user_id;
        $lg->id_giocatore=$sp->id_giocatore;
        $lg->id_stagione=$sp->id_stagione;
        $lg->id_season_player=$sp->id;
        $lg->azione="Modifica ricevuta n. ".$r->numero;
        $lg->save();
        return response()->json($r , 200);
    }

    /**
     * Display the specified resource.
     */
    public function getCategorie(Request $request)
    {
        $d=Carbon::now()->format('Y-m-d');
        $cor=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
        $cat=Categoria::where('id_stagione',$cor->id)->orderBy('inizio')->get();
        return response()->json($cat , 200);
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

    public function allinea()
    {
        $g=Genitore::all();
        foreach($g as $gen)
        {
            if($gen->id_giocatore!=null)
            {
                $gio=Giocatore::find($gen->id_giocatore);
                if($gio!=null)
                {
                    $gio->id_genitore=$gen->id;
                    $gio->save();
                }
            }
        }
    }

    public function allineaDate()
    {
        $r=Ricevuta::all();
        foreach($r as $ri)
        {
            $d=explode("/",$ri->data_genitore);
            //dd($d);
            if($d!=null)
                if($d[0]!=null)
                    $ri->data_genitore_n=($d[2]."-".$d[1]."-".$d[0]);
            $d2=explode("/",$ri->data_giocatore);
            if($d2!=null)
                if($d2[0]!=null)
                    $ri->data_giocatore_n=($d2[2]."-".$d2[1]."-".$d2[0]);
            $ri->save();
        }
    }
}
