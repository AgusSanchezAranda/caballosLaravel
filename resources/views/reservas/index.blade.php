<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sus reservas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Caballo</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Fecha Reserva</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Turno</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Comentario</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservas as $reserva)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                    {{ $reserva->caballos->nombre}}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                    {{ $reserva->fecha_reserva}}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $reserva->turno}}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                    {{ $reserva->comentario}}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center mt-4 space-x-8">
                                        <a href="{{route('reservas.edit', $reserva->id) }}"
                                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">Editar</a>
                                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center mt-4 space-x-8">
            <a href="{{route('reservas.create') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">Nueva
                Reserva</a>
        </div>
    </div>
</x-app-layout>