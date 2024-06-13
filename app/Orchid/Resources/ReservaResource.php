<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;

class ReservaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Reserva::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('id_user')
            ->title('ID_USUARIO'),
            Input::make('id_caballo')
            ->title('ID_CABALLO'),
            DateTimer::make('fecha_reserva')
            ->title('FECHA RESERVA')
            ->format('Y-m-d'),
            Input::make('turno')
            ->title('TURNO'),
            TextArea::make('comentario')
            ->title('COMENTARIO')
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('id_user','ID USUARIO'),
            TD::make('id_caballo','ID CABALLO'),
            TD::make('fecha_reserva','FECHA RESERVA'),
            TD::make('turno','TURNO'),
            TD::make('comentario','COMENTARIO')
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('id_user','ID USUARIO'),
            Sight::make('id_caballo','ID CABALLO'),
            Sight::make('fecha_reserva','FECHA RESERVA'),
            Sight::make('turno','TURNO'),
            Sight::make('comentario','COMENTARIO')
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
