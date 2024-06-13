<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Caballo;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class ReservaController extends Controller
{


    public function index()
    {
        //busco la id del usuario activo
        $user = Auth::user();
        $user_id = $user->id;

        $reservas = Reserva::where('id_user', $user_id)
            ->orderBy('fecha_reserva')
            ->orderBy('turno')
            ->get();

        //le mando todos los caballos a la vista
        return view('reservas.index', compact('reservas'));
    }


    public function create()
    {
        return view('reservas.create');
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'caballo' => 'required',
            'fecha_reserva' => 'required',
            'turno' => 'required',
            'comentario' => 'nullable|string|max:200'
        ]);

        //si el comentario está vacío lo ponemos a null
        if (empty(trim($validateData['comentario']))) {
            $validateData['comentario'] = "Sin comentario!";
        }

        //ajusto el turno
        switch ($validateData['turno']) {
            case 'turno10':
                $validateData['turno'] = 10;
                break;
            case 'turno11':
                $validateData['turno'] = 11;
                break;
            case 'turno12':
                $validateData['turno'] = 12;
                break;
            case 'turno13':
                $validateData['turno'] = 13;
                break;
        }


        //busco la id del caballo
        $nombre_caballo = $validateData['caballo'];
        $caballo = Caballo::where('nombre', $nombre_caballo)->first();

        $validateData['id_caballo'] = $caballo->id;

        //busco la id del usuario activo
        $user = Auth::user();
        $user_id = $user->id;
        $user_email = $user->email;
        $validateData['id_user'] = $user_id;

        Reserva::create([
            'id_user' => $validateData['id_user'],
            'id_caballo' => $validateData['id_caballo'],
            'fecha_reserva' => $validateData['fecha_reserva'],
            'turno' => $validateData['turno'],
            'comentario' => $validateData['comentario'],
        ]);

        $content_mail = "Su reserva se ha realizado correctamente\n" .
            "Datos de la reserva:\n" .
            "Fecha ---> " . $validateData['fecha_reserva'] . "\n" .
            "Turno ---> " . $validateData['turno'] . "\n" .
            "Caballo ---> " . $nombre_caballo;


        $data_mail = [
            'subject' => 'Nueva Reserva',
            'email' => $user_email,
            'content' => $content_mail
        ];

        $email_controller = new EmailController();
        $email_controller->sendEmail($data_mail);


        return redirect()->route('reservas.index');

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        return view('reservas.edit', compact('reserva'));
    }

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'caballo' => 'required',
            'fecha_reserva' => 'required',
            'turno' => 'required',
            'comentario' => 'nullable|string|max:200'
        ]);

        //si el comentario está vacío lo ponemos a null
        if (empty(trim($validateData['comentario']))) {
            $validateData['comentario'] = "Sin comentario!";
        }

        //ajusto el turno
        switch ($validateData['turno']) {
            case 'turno10':
                $validateData['turno'] = 10;
                break;
            case 'turno11':
                $validateData['turno'] = 11;
                break;
            case 'turno12':
                $validateData['turno'] = 12;
                break;
            case 'turno13':
                $validateData['turno'] = 13;
                break;
        }


        //busco la id del caballo
        $nombre_caballo = $validateData['caballo'];
        $caballo = Caballo::where('nombre', $nombre_caballo)->first();

        $validateData['id_caballo'] = $caballo->id;

        $reserva = Reserva::findOrFail($id);

        $reserva->update([
            'id_caballo' => $validateData['id_caballo'],
            'fecha_reserva' => $validateData['fecha_reserva'],
            'turno' => $validateData['turno'],
            'comentario' => $validateData['comentario'],
        ]);


        //envio de mail 
        $user = Auth::user();
        $user_email = $user->email;

        $content_mail = "Su reserva se ha actualizado correctamente\n" .
            "Nuevos datos de la reserva:\n" .
            "Fecha ---> " . $validateData['fecha_reserva'] . "\n" .
            "Turno ---> " . $validateData['turno'] . "\n" .
            "Caballo ---> " . $nombre_caballo;


        $data_mail = [
            'subject' => 'Modificación Reserva',
            'email' => $user_email,
            'content' => $content_mail
        ];

        $email_controller = new EmailController();
        $email_controller->sendEmail($data_mail);


        return redirect()->route('reservas.index');
    }

    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        //envio mail eliminacion reserva
         //envio de mail 
         $user = Auth::user();
         $user_email = $user->email;
 
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

        return redirect()->route('reservas.index');
    }

    public function turnosDisponibles(Request $request)
    {

        $fecha = $request->input('fecha');
        $turnos = [];

        $countT10 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 10)
            ->count();
        if ($countT10 < 5) {
            $turnos[] = ['value' => 'turno10', 'label' => 'Turno 10:00'];
        }

        $countT11 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 11)
            ->count();
        if ($countT11 < 5) {
            $turnos[] = ['value' => 'turno11', 'label' => 'Turno 11:00'];
        }

        $countT12 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 12)
            ->count();
        if ($countT12 < 5) {
            $turnos[] = ['value' => 'turno12', 'label' => 'Turno 12:00'];
        }

        $countT13 = Reserva::where('fecha_reserva', $fecha)
            ->where('turno', 13)
            ->count();
        if ($countT13 < 5) {
            $turnos[] = ['value' => 'turno13', 'label' => 'Turno 13:00'];
        }

        return response()->json($turnos);
    }

    public function caballosDisponibles(Request $request)
    {

        $fecha = $request->input('fecha');
        $turno = $request->input('turno');

        //ajusto el turno
        switch ($turno) {
            case 'turno10':
                $turno = 10;
                break;
            case 'turno11':
                $turno = 11;
                break;
            case 'turno12':
                $turno = 12;
                break;
            case 'turno13':
                $turno = 13;
                break;
        }


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
                ->pluck('nombre');
            $caballos_elegir[] = ['value' => $nombre, 'label' => $nombre];
        }

        return response()->json($caballos_elegir);
    }

}
