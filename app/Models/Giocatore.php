<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giocatore extends Model
{
    use HasFactory;

    public function genitore()
    {
        return $this->belongsTo('App\Models\Genitore', 'id_genitore');
    }
}
