<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;

class CaballoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Caballo::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('nombre')
            ->title('NOMBRE'),
            Input::make('raza')
            ->title('RAZA'),
            Input::make('chip')
            ->title('CHIP'),
            DateTimer::make('fecha_nac')
            ->title('FECHA NACIMIENTO')
            ->format('Y-m-d'),
            Input::make('enfermo')
            ->title('ENFERMO'),
            TextArea::make('observaciones')
            ->title('OBSERVACIONES')
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
            TD::make('nombre','NOMBRE'),
            TD::make('raza','RAZA'),
            TD::make('chip','CHIP'),
            TD::make('fecha_nac','FECHA NACIMENTO'),
            TD::make('enfermo','ENFERMO'),
            TD::make('observaciones','OBSERVACIONES')
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
            Sight::make('nombre','NOMBRE'),
            Sight::make('raza','RAZA'),
            Sight::make('chip','CHIP'),
            Sight::make('fecha_nac','FECHA NACIMENTO'),
            Sight::make('enfermo','ENFERMO'),
            Sight::make('observaciones','OBSERVACIONES')
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
