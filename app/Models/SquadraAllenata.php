<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SquadraAllenata extends Model
{
    use HasFactory;

    protected $fillable = ['id_stagione','id_categoria','id_staff','id_utente'];

    // Relazione con Utente (Allenatore)
    public function allenatore(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utente');
    }

    // Relazione con Categoria
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
