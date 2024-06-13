<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Reserva extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'id_caballo' => $this->id_caballo,
            'fecha_reserva' => $this->fecha_reserva,
            'turno' => $this->turno,
            'comentario' => $this->comentario,
        ];
    }
}
