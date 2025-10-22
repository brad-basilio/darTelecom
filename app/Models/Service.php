<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'subtitle', 'icono', 'descripcion_breve', 'beneficios', 'descripcion_extensa', 'visible'];
}
