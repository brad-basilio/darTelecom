<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'album_id',
        'title', 
        'slug', 
        'subtitle', 
        'icono', 
        'descripcion_breve', 
        'beneficios', 
        'descripcion_extensa', 
        'visible'
    ];

    /**
     * Relación con el servicio padre
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relación con el álbum de imágenes
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}