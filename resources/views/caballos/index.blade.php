<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Caballos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Nombre</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Raza</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Fecha Nacimiento</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Número Chip</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Enfermo</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($caballos as $caballo)
                                                @php
                                                    $enf = $caballo->enfermo == 0 ? 'NO' : 'SI';
                                                @endphp
                                                <tr>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $caballo->nombre}}
                                                    </td>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $caballo->raza}}
                                                    </td>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                                        {{ $caballo->fecha_nac}}
                                                    </td>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $caballo->chip}}
                                                    </td>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $enf}}</td>
                                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                                        {{ $caballo->observaciones}}
                                                    </td>
                                                </tr>
                        @endforeach
                    </tbody>
                </table>



                <!-- Galería de fotos -->
                <br><br>
                <div class="py-8">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4 text-center">
                        {{ __('Galería de Fotos') }}
                    </h2>
                    <br><br>
                    <div class="flex flex-wrap justify-center gap-4">
                        @foreach($caballos as $caballo)
                            <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                                <div class="w-50 h-50 flex items-center justify-center">
                                    <img src="{{ asset('images/' . $caballo->nombre . '.png') }}"
                                        alt="{{ $caballo->nombre }}"
                                        style="width: 250px; height: 250px; object-fit: contain;">
                                </div>
                                <div class="p-4">
                                    <h4 class="text-center text-gray-900 dark:text-white">{{ $caballo->nombre }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>