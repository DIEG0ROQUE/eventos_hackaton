@extends('layouts.app')

@section('title', 'Eventos Académicos')

@section('header-title', 'Eventos Académicos')

@section('content')
<div class="contenedor-principal" style="display: block; max-width: 1400px; margin: 0 auto; padding: 2rem;">
    
    <!-- Sección de Bienvenida -->
    <div class="tarjeta" style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1rem;">
            Bienvenido a Eventos Académicos
        </h2>
        <p style="color: var(--color-texto-secundario); font-size: 1rem; line-height: 1.8;">
            Descubre y participa en hackathons, datathons y competencias de programación. 
            Únete a equipos, desarrolla soluciones innovadoras y gana premios increíbles.
        </p>
    </div>

    <!-- Filtros (Opcional - por ahora simple) -->
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;">
            Eventos Disponibles
        </h3>
    </div>

    <!-- Grid de Eventos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
        @forelse($events as $event)
        <!-- Tarjeta de Evento -->
        <div class="tarjeta" style="cursor: pointer; transition: transform 0.3s, box-shadow 0.3s;" 
             onclick="window.location='{{ route('events.show', $event) }}'"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 20px rgba(0,0,0,0.15)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
            
            <!-- Estado del Evento -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <span class="etiqueta etiqueta-{{ $event->status === 'open' ? 'abierto' : 'programador' }}">
                    {{ ucfirst($event->status) }}
                </span>
                <span style="color: var(--color-texto-secundario); font-size: 0.85rem;">
                    {{ $event->type }}
                </span>
            </div>

            <!-- Título -->
            <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-texto-principal);">
                {{ $event->title }}
            </h3>

            <!-- Descripción -->
            <p style="color: var(--color-texto-secundario); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem; 
                      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $event->description }}
            </p>

            <!-- Información Rápida -->
            <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; 
                        padding-top: 1rem; border-top: 1px solid var(--color-borde);">
                <!-- Fecha -->
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-texto-secundario); font-size: 0.85rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span>{{ $event->start_date->format('d M Y') }}</span>
                </div>

                <!-- Ubicación -->
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-texto-secundario); font-size: 0.85rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $event->location }}
                    </span>
                </div>

                <!-- Participantes -->
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-texto-secundario); font-size: 0.85rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span>{{ $event->teams->count() }} equipos</span>
                </div>
            </div>

            <!-- Botón -->
            <a href="{{ route('events.show', $event) }}" 
               style="display: block; text-align: center; padding: 0.7rem; background-color: var(--color-primario); 
                      color: white; border-radius: var(--radio-borde); text-decoration: none; font-weight: 600; 
                      transition: background-color 0.3s;"
               onmouseover="this.style.backgroundColor='var(--color-primario-oscuro)'"
               onmouseout="this.style.backgroundColor='var(--color-primario)'">
                Ver Detalles
            </a>
        </div>
        @empty
        <!-- Sin Eventos -->
        <div class="tarjeta" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                 style="margin: 0 auto 1rem; opacity: 0.3;">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">
                No hay eventos disponibles
            </h3>
            <p style="color: var(--color-texto-secundario); margin-bottom: 1.5rem;">
                Aún no hay eventos creados. ¡Vuelve pronto para ver nuevas oportunidades!
            </p>
            @auth
                @if(Auth::user()->email === 'admin@ejemplo.com')
                <a href="#" 
                   style="display: inline-block; padding: 0.7rem 1.5rem; background-color: var(--color-primario); 
                          color: white; border-radius: var(--radio-borde); text-decoration: none; font-weight: 600;">
                    Crear Primer Evento
                </a>
                @endif
            @endauth
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($events->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $events->links() }}
    </div>
    @endif

    <!-- Sección de Información Adicional -->
    <div style="margin-top: 3rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        
        <!-- ¿Por qué participar? -->
        <div class="tarjeta">
            <div style="width: 48px; height: 48px; background-color: var(--color-primario); border-radius: var(--radio-borde); 
                        display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                    <path d="M4 22h16" />
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                </svg>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                Gana Premios
            </h4>
            <p style="color: var(--color-texto-secundario); font-size: 0.9rem; line-height: 1.6;">
                Compite por premios en efectivo y reconocimientos en cada evento.
            </p>
        </div>

        <!-- Aprende -->
        <div class="tarjeta">
            <div style="width: 48px; height: 48px; background-color: var(--color-primario); border-radius: var(--radio-borde); 
                        display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                </svg>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                Aprende Haciendo
            </h4>
            <p style="color: var(--color-texto-secundario); font-size: 0.9rem; line-height: 1.6;">
                Desarrolla habilidades prácticas trabajando en proyectos reales.
            </p>
        </div>

        <!-- Networking -->
        <div class="tarjeta">
            <div style="width: 48px; height: 48px; background-color: var(--color-primario); border-radius: var(--radio-borde); 
                        display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                Haz Networking
            </h4>
            <p style="color: var(--color-texto-secundario); font-size: 0.9rem; line-height: 1.6;">
                Conoce y colabora con otros estudiantes apasionados por la tecnología.
            </p>
        </div>

    </div>

</div>
@endsection

@push('styles')
<style>
/* Estilos adicionales para la tarjeta hover */
.tarjeta {
    transition: all 0.3s ease;
}
</style>
@endpush