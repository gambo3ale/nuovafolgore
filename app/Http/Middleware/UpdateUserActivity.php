<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        //dd('Middleware executed');
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(5); // Considera l'utente online se ha fatto una richiesta negli ultimi 5 minuti
            Cache::put('user-is-online-' . Auth::user()->id, now(), $expiresAt); // Memorizza l'orario dell'ultima attività
            //dd(Cache::get('user-is-online-' . Auth::user()->id));
        }

        return $next($request);
    }
}
