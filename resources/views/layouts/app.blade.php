<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eventos Académicos')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <!-- Stack para CSS adicional de páginas específicas -->
    @stack('styles')
</head>
<body>
    <!-- Encabezado -->
    <header class="encabezado">
        @if(Route::currentRouteName() !== 'home')
        <a href="{{ route('home') }}" class="boton-regresar">
            <svg class="flechita-izquierda" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
        @endif
        
        <div class="titulo-principal">
            <div class="copita-trofeo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                    <path d="M4 22h16" />
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                </svg>
            </div>
            <h1>@yield('header-title', 'Eventos Académicos')</h1>
        </div>

        <!-- Menú de navegación (opcional) -->
        <nav class="navegacion" style="margin-left: auto;">
            @auth
                <span style="margin-right: 1rem; color: var(--color-texto-secundario);">
                    Hola, {{ Auth::user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="boton-secundario">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="boton-secundario">Iniciar Sesión</a>
            @endauth
        </nav>
    </header>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="alerta alerta-exito" style="padding: 1rem; margin: 1rem; background: #d4edda; color: #155724; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta alerta-error" style="padding: 1rem; margin: 1rem; background: #f8d7da; color: #721c24; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alerta alerta-error" style="padding: 1rem; margin: 1rem; background: #f8d7da; color: #721c24; border-radius: 8px;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (opcional) -->
    <footer style="background: var(--color-fondo-tarjeta); padding: 2rem; text-align: center; margin-top: 3rem;">
        <p style="color: var(--color-texto-secundario);">
            &copy; {{ date('Y') }} Eventos Académicos. Todos los derechos reservados.
        </p>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Stack para JavaScript adicional de páginas específicas -->
    @stack('scripts')
</body>
</html>