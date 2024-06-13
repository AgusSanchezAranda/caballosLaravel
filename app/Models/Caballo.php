<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Caballo extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $fillable = ['nombre', 'raza', 'chip', 'fecha_nac', 'enfermo', 'en_activo', 'observaciones'];

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
