<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partita extends Model
{
    use HasFactory;
    protected $fillable = ['id_stagione','id_categoria','id_avversario','id_campo','data','ora','descrizione','giornata','girone','inserita','squadra','campionato','avversario','campo'];
}
