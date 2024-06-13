<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hípica Portada Alta</title>
    <!-- Incluye Tailwind CSS desde un CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Fuente Dancing Script -->
    <link href='https://fonts.googleapis.com/css?family=Dancing Script' rel='stylesheet'>
    <style>
        body {
            font-family: 'Dancing Script';
            font-size: 22px;
            background-color: #e0f2f1;
        }

        .sepia-light {
            background-color: #f4e2c7;
            filter: sepia(10%);
        }
    </style>
</head>

<body class="bg-blue-50 dark:bg-gray-900">

    <!-- Contenedor principal -->
    <div class="flex flex-col items-center justify-start h-screen">
        <!-- Enlace Admin -->
        <div class="w-full flex justify-end p-4">
            <a href="{{ url('/admin') }}" class="text-lg text-gray-700 underline dark:text-white">
                Admin
            </a>
        </div>
        <!-- Card -->
        <div class="flex flex-col items-center justify-start mt-20 sepia-light rounded-lg p-20">
            <h1 class="text-6xl font-dancing-script font-weight-400 text-gray-800 dark:text-gray-200 text-center">
                Hípica Portada Alta</h1>

            <img src="{{ asset('images/caballo_icon.png') }}" alt="Foto de caballos"
                class="w-full h-auto object-cover rounded my-12">

            <p class="text-4xl font-dancing-script font-weight-600 text-gray-600 dark:text-gray-400 text-center">
                Caballos para disfrutar</p>
        </div>

        <!-- Botones -->
        <div class="flex justify-center mt-8 space-x-8">
            @if (Route::has('login'))
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300"
                            style="font-family: Arial, sans-serif; font-size: 16px;">
                            Inicio
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300"
                            style="font-family: Arial, sans-serif; font-size: 16px;">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-300"
                                style="font-family: Arial, sans-serif; font-size: 16px;">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="w-full h-32 bg-transparent flex items-center justify-center">
            <span class="opacity-0">Espacio vacío</span>
        </div>
    </div>
</body>

</html>