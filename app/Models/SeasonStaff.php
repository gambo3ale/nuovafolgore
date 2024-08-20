<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonStaff extends Model
{
    use HasFactory;
    protected $fillable = ['id_staff','id_categoria','id_stagione','matricola','taglia_kit'];
}
