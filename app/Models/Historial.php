<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Historial extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $fillable = ['id_user', 'id_caballo', 'fecha_reserva', 'turno', 'comentario'];

}
