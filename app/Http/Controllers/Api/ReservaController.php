<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Reserva;
use App\Models\Caballo;
use App\Http\Resources\Reserva as ReservaResource;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Collection;

class ReservaController extends BaseController
{
    public function index()
    {
        $reservas = Reserva::where('id_user', auth()->user()->id)
            ->orderBy('fecha_reserva')
            ->orderBy('turno')
            ->get();
        return $this->sendResponse(ReservaResource::collection($reservas), 'Reservas fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'caballo' => 'required',
            'fecha_reserva' => 'required',
            'turno' => 'required',
            'comentario' => 'nullable|string|max:200'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }


        //si el comentario está vacío lo ponemos a null
        if (empty(trim($input['comentario']))) {
            $input['comentario'] = "Sin comentario!";
        }


        //busco la id del caballo
        $nombre_caballo = $input['caballo'];
        $caballo = Caballo::where('nombre', $nombre_caballo)->first();


        $reserva = new Reserva();
        $reserva->id_user = auth()->user()->id;
        $reserva->id_caballo = $caballo->id;
        $reserva->fecha_reserva = $input['fecha_reserva'];
        $reserva->turno = $input['turno'];
        $reserva->comentario = $input['comentario'];

        //guarda datos en la bd
        $reserva->save();


        //envio de mail de confirmación
        $content_mail = "Su reserva se ha realizado correctamente\n" .
            "Datos de la reserva:\n" .
            "Fecha ---> " . $reserva->fecha_reserva . "\n" .
            "Turno ---> " . $reserva->turno . "\n" .
            "Caballo ---> " . $nombre_caballo;

        $user_email = auth()->user()->email;

        $data_mail = [
            'subject' => 'Nueva Reserva',
            'email' => $user_email,
            'content' => $content_mail
        ];

        $email_controller = new EmailController();
        $email_controller->sendEmail($data_mail);


        //envio de datos api
        return $this->sendResponse(new ReservaResource($reserva), 'Reserva created.');
    }


    //me va a mostrar una única reserva, la que le pase la id
    public function show($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return $this->sendError('Reserva does not exist.');
        }
        return $this->sendResponse(new ReservaResource($reserva), 'Reserva fetched.');
    }

    public function update(Request $request, Reserva $reserva)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'caballo' => 'required',
            'fecha_reserva' => 'required',
            'turno' => 'required',
            'comentario' => 'nullable|string|max:200'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        //si el comentario está vacío lo ponemos a null
        if (empty(trim($input['comentario']))) {
            $input['comentario'] = "Sin comentario!";
        }

        //busco la id del caballo
        $nombre_caballo = $input['caballo'];
        $caballo = Caballo::where('nombre', $nombre_caballo)->first();


        //el objeto reserva que me llega como parámetro ya tiene la id reserva
        //cambiamos los campos a modificar
        $reserva->id_caballo = $caballo->id;
        $reserva->fecha_reserva = $input['fecha_reserva'];
        $reserva->turno = $input['turno'];
        $reserva->comentario = $input['comentario'];

        //guarda datos en la bd
        $reserva->save();


        //envio de mail de confirmación
        $content_mail = "Su reserva se ha modificado correctamente\n" .
            "Datos de la reserva:\n" .
            "Fecha ---> " . $reserva->fecha_reserva . "\n" .
            "Turno ---> " . $reserva->turno . "\n" .
            "Caballo ---> " . $nombre_caballo;

        $user_email = auth()->user()->email;

        $data_mail = [
            'subject' => 'Modificación Reserva',
            'email' => $user_email,
            'content' => $content_mail
        ];

        $email_controller = new EmailController();
        $email_controller->sendEmail($data_mail);

        //respuesta api        
        return $this->sendResponse(new ReservaResource($reserva), 'Reserva updated.');
    }

    public function destroy($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);
        if (is_null($reserva)) {
            return $this->sendError('Reserva does not exist.', 'Reserva NOT deleted.');
        } else {
            $reserva->delete();

            //envio mail eliminacion reserva
            $user_email = auth()->user()->email;

            $content_mail = "Su reserva se ha eliminado correctamente\n" .
                "Datos de la reserva eliminada:\n" .
                "Fecha ---> " . $reserva->fecha_reserva . "\n" .
                "Turno ---> " . $reserva->turno;

            $data_mail = [
                'subject' => 'Reserva eliminada',
                'email' => $user_email,
                'content' => $content_mail
            ];

            $email_controller = new EmailController();
            $email_controller->sendEmail($data_mail);

            return $this->sendResponse([], 'Reserva deleted.');
        }
    }


    public function turnosDisponibles(Request $request)
    {

        $fecha = $request->input('fecha');
        $turnos = [];

        $countT10 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 10)
            ->count();
        if ($countT10 < 5) {
            $turnos[] = 'Turno 10:00';
        }

        $countT11 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 11)
            ->count();
        if ($countT11 < 5) {
            $turnos[] = 'Turno 11:00';
        }

        $countT12 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 12)
            ->count();
        if ($countT12 < 5) {
            $turnos[] = 'Turno 12:00';
        }

        $countT13 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 13)
            ->count();
        if ($countT13 < 5) {
            $turnos[] = 'Turno 13:00';
        }

        return $this->sendResponse($turnos, 'Turnos avaiable');
    }

    public function caballosDisponibles(Request $request)
    {

        $fecha = $request->input('fecha');
        $turno = $request->input('turno');

        //caballos ya seleccionados en fecha y turno
        $caballos_reservados = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', $turno)
            ->pluck('id_caballo');

        //caballos enfermos
        $caballos_enfermos = Caballo::where('enfermo', 1)
            ->pluck('id');

        //caballos totales
        $caballos_totales = Caballo::pluck('id')->toArray();



        $caballos_no_disponibles = Collection::make($caballos_reservados)->merge($caballos_enfermos)->toArray();

        $caballos_disponibles = array_diff($caballos_totales, $caballos_no_disponibles);

        //rescato los nombres desde las id
        $caballos_elegir = [];
        foreach ($caballos_disponibles as $id_caballo) {
            $nombre = Caballo::where('id', $id_caballo)
                ->pluck('nombre')
                ->first();
            $caballos_elegir[] = $nombre;
        }

        return $this->sendResponse($caballos_elegir, 'Caballos avaiable');
    }


    public function nombreCaballo($id_caballo)
    {
        $nombre_caballo = Caballo::where('id', $id_caballo)
            ->pluck('nombre');


        if (is_null($nombre_caballo)) {
            return $this->sendError('Caballo does not exist.');
        }
        return $this->sendResponse($nombre_caballo, 'Nombre Caballo avaiable.');

    }

    public function reservasRw()
    {

        $reservas = Reserva::where('id_user', auth()->user()->id)
            ->orderBy('fecha_reserva')
            ->orderBy('turno')
            ->get();

        $reservasResponse = [];

        foreach ($reservas as $r) {
            $nombreCaballo = Caballo::where('id', $r->id_caballo)
                ->pluck('nombre')
                ->first();

            switch ($r->turno) {
                case 10:
                    $trn = 'Turno 10:00';
                    break;
                case 11:
                    $trn = 'Turno 11:00';
                    break;
                case 12:
                    $trn = 'Turno 12:00';
                    break;
                case 13:
                    $trn = 'Turno 13:00';
                    break;
                default:
                    break;
            }

            $reservaResponse = [
                'id' => $r->id,
                'nombre_caballo' => $nombreCaballo,
                'fecha_reserva' => $r->fecha_reserva,
                'turno' => $trn,
                'comentario' => $r->comentario
            ];

            $reservasResponse[] = $reservaResponse;

        }

        return $this->sendResponse($reservasResponse, 'Reservas avaiable');

    }




}


