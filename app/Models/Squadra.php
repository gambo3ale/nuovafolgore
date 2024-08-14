<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squadra extends Model
{
    use HasFactory;
    protected $fillable = ['nome','ranking','comune','provincia'];
}
