<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SeasonStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Staff;

class StaffController extends Controller
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
            return view('staff.index')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function registra()
    {
        if (Auth::check() )
        {
            $d=Carbon::now()->format('Y-m-d');
            $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
            $staffNonPresente = Staff::whereNotIn('id', function($query) use ($s) {
                $query->select('id_staff')
                      ->from('season_staff')
                      ->where('id_stagione', $s->id);
            })->get();
            $cat=Categoria::where('id_stagione',$s->id)->orderBy('inizio')->get();
            $data=['stag'=>$s, 'staff'=>$staffNonPresente,'cat'=>$cat];
            return view('staff.registra')->with('data',$data);
        }
        return redirect(route('welcome'));
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
            return view('staff.create')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        parse_str($request->dati, $dati);
        $s=Staff::create($dati);
        return response()->json($s, 200);
    }

    public function memorizza(Request $request)
    {
        parse_str($request->dati, $dati);
        $s=SeasonStaff::create($dati);
        return response()->json($s, 200);
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
            $data=['stag'=>$s];
            return view('staff.show')->with('data',$data);
        }
        return redirect(route('welcome'));
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
        $gio = DB::table('season_staff')
            ->join('staff', 'staff.id', '=', 'season_staff.id_staff')
            ->leftJoin('categorias', 'categorias.id', '=', 'season_staff.id_categoria')
            ->select(
                'season_staff.id_staff',
                DB::raw('MAX(season_staff.id) as id'),
                DB::raw('MAX(season_staff.taglia_kit) as taglia_kit'),
                DB::raw('MAX(staff.cognome) as cognome'),
                DB::raw('MAX(staff.nome) as nome'),
                DB::raw('MAX(staff.ruolo) as ruolo'),
                DB::raw('MAX(staff.qualifica) as qualifica'),
                DB::raw('MAX(staff.telefono) as telefono'),
                DB::raw('MAX(staff.email) as email'),
                DB::raw('GROUP_CONCAT(DISTINCT categorias.categoria_estesa SEPARATOR ", ") as categorie_estese'),
                DB::raw('GROUP_CONCAT(DISTINCT categorias.sigla SEPARATOR ", ") as sigle')
            )
            ->where('season_staff.id_stagione', $request->id)
            ->groupBy('season_staff.id_staff')
            ->orderBy('cognome')
            ->get();

        return response()->json($gio, 200);
    }
}
