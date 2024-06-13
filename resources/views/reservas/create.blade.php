<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mx-auto"
                style="max-width: 500px;">


                <form method="POST" action="{{ route('reservas.store')}}" class="mx-auto">
                    @csrf

                    <div class="mb-5">
                        <label for="fecha_reserva"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Reserva</label>
                        <input type="text" name="fecha_reserva" id="fecha_reserva"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required placeholder="Seleccione una fecha">
                    </div>

                    <div class="mb-5">
                        <label for="turno"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Turno</label>
                        <select name="turno" id="turno"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required disabled>
                            <option value="" selected disabled>Seleccione un turno</option>
                        </select>
                    </div>






                    <div class="mb-5">
                        <label for="caballo"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Caballo</label>
                        <select name="caballo" id="caballo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required disabled>
                            <option value="" selected disabled>Seleccione caballo</option>
                        </select>
                    </div>




                    <div class="mb-5"></div>
                    <label for="Comentario"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comentario</label>
                    <input type="text" name="comentario" id="comentario"
                        class="text-black bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-left dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
            </div>
            <div class="flex justify-center mt-4 space-x-8">
                <button type="submit"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">Guardar</button>

                <a href="{{ route('reservas.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">Cancelar</a>
            </div>

            </form>



        </div>
    </div>
    </div>

    <!-- Incluye los scripts de flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fechaReservaInput = document.getElementById('fecha_reserva');
            const caballoSelect = document.getElementById('caballo');
            const turnoSelect = document.getElementById('turno');
            const turnosDisponiblesRoute = '{{ route('reservas.turnosDisponibles') }}';
            const caballosDisponiblesRoute = '{{ route('reservas.caballosDisponibles') }}';

            let selectedFecha = '';

            flatpickr("#fecha_reserva", {
                dateFormat: "Y-m-d",
                minDate: "today",
                maxDate: new Date().fp_incr(30), // 30 días a partir de hoy
                enable: [
                    function (date) {
                        // Habilitar solo sábados y domingos
                        return (date.getDay() === 6 || date.getDay() === 0); // 0: Domingo, 6: Sábado
                    }
                ],
                locale: {
                    firstDayOfWeek: 1, // Comenzar la semana en lunes
                    weekdays: {
                        shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        selectedFecha = dateStr;
                        turnoSelect.disabled = false;
                        fetchTurnos(dateStr);
                    } else {
                        turnoSelect.disabled = true;
                    }
                }
            });

            function fetchTurnos(dateStr) {
                const url = turnosDisponiblesRoute + '?fecha=' + dateStr;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        turnoSelect.innerHTML = '<option value="" selected disabled>Seleccione un turno</option>';
                        data.forEach(turno => {
                            let option = document.createElement('option');
                            option.value = turno.value;
                            option.textContent = turno.label;
                            turnoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching turnos:', error));
            }

            turnoSelect.addEventListener('change', function () {
                const turno = turnoSelect.value;
                if (turno && selectedFecha) {
                    fetchCaballos(selectedFecha, turno);
                }
            });

            function fetchCaballos(fecha, turno) {
                const url = `${caballosDisponiblesRoute}?fecha=${fecha}&turno=${turno}`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        caballoSelect.innerHTML = '<option value="" selected disabled>Seleccione un caballo</option>';
                        data.forEach(caballo => {
                            let option = document.createElement('option');
                            option.value = caballo.value;
                            option.textContent = caballo.label;
                            caballoSelect.appendChild(option);
                        });
                        caballoSelect.disabled = false;
                    })
                    .catch(error => console.error('Error fetching caballos:', error));
            }


        });
    </script>

</x-app-layout>