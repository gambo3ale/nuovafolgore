<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stagione;
use App\Models\Genitore;
use App\Models\Giocatore;
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
}
