<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Giocatore;
use App\Models\Genitore;
use App\Models\Pagamento;
use App\Models\SeasonPlayer;
use App\Models\Ricevuta;
use App\Models\LogAzione;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class GamboController extends Controller
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
            $u=User::all();
            $usersWithStatus = $this->getAllUsersWithStatus();
            $data=['stag'=>$s, 'user'=>$usersWithStatus, 'id_ut'=>Auth::user()->id];
            return view('gambo.index')->with('data',$data);
        }
        return redirect(route('welcome'));
    }

    public function isUserOnline($userId)
    {
        return Cache::has('user-is-online-' . $userId);
    }

    public function getUserStatus($userId)
    {
        $lastSeen = Cache::get('user-is-online-' . $userId);

        if ($lastSeen) {
            $isOnline = Carbon::now()->diffInMinutes($lastSeen) <= 5; // Se l'ultima attività è entro 5 minuti
            $lastSeenTime = Carbon::parse($lastSeen)->diffForHumans(); // Differenza di tempo in formato leggibile
        } else {
            $isOnline = false;
            $lastSeenTime = 'N/A'; // Non disponibile se non ci sono dati
        }

        return ['isOnline' => $isOnline, 'lastSeen' => $lastSeenTime];
    }

    public function getAllUsersWithStatus()
    {
        $users = User::all();

        $usersWithStatus = $users->map(function ($user) {
            $status = $this->getUserStatus($user->id);
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'isOnline' => $status['isOnline'],
                'lastSeen' => $status['lastSeen'],
            ];
        });

        return $usersWithStatus;
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

    public function visualizzaLog(Request $request)
    {
        $d=Carbon::now()->format('Y-m-d');
        $s=Stagione::where('inizio','<',$d)->where('fine','>',$d)->first();
        $lg=DB::table('log_aziones')
        ->join('giocatores','giocatores.id','log_aziones.id_giocatore')
        ->where('log_aziones.id_stagione',$s->id)
        ->where('id_utente',$request->id)
        ->select('log_aziones.*','giocatores.cognome','giocatores.nome')->orderBy('created_at')->get();
        return response()->json($lg , 200);
    }
}
