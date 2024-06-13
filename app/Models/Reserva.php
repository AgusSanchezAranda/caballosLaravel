<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Reserva extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    //esto es sólo lo que se puede editar, crear.
    protected $fillable = ['id_user', 'id_caballo', 'fecha_reserva', 'turno', 'comentario'];


    public function caballos(){
        return $this->belongsTo(Caballo::class, 'id_caballo');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
