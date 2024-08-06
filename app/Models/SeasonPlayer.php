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
}
