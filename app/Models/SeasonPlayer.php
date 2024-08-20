<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonPlayer extends Model
{
    use HasFactory;

    public function giocatore()
    {
        return $this->belongsTo('App\Models\Giocatore', 'id_giocatore');
    }

    public function stagione()
    {
        return $this->belongsTo('App\Models\Stagione', 'id_stagione');
    }

    public function ricevute()
    {
        return $this->hasMany('App\Models\Ricevuta', 'id_season_player');
    }

    public function pagamenti()
    {
        return $this->hasMany('App\Models\Pagamento', 'id_season_player');
    }
}
