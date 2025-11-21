@extends('layouts.app')

@section('title', $event->title . ' - Eventos Académicos')

@section('header-title', $event->title)

@section('content')
<!-- Contenedor Principal -->
<div class="contenedor-principal">
    <!-- Sección Izquierda -->
    <section class="seccion-izquierda">
        <!-- Cabecera del Evento -->
        <div class="cabecera-evento">
            <h2 class="titulo-evento">{{ $event->title }}</h2>
            <div class="informacion-evento">
                <span class="dato-evento">
                    <svg class="calendarcito" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    {{ $event->start_date->format('d M Y') }}
                </span>
                <span class="dato-evento">
                    <svg class="mapita-mundo" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    {{ $event->location }}
                </span>
                <span class="dato-evento">
                    <svg class="relojito" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    {{ $event->duration_hours }} horas
                </span>
            </div>
            <div class="botones-evento">
                <button class="boton-estado">{{ ucfirst($event->status) }}</button>
                
                @auth
                    @if($event->isOpen() && !$isRegistered)
                        <form action="{{ route('events.register', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="boton-registrarse">Registrarse al Evento</button>
                        </form>
                    @elseif($isRegistered)
                        <button class="boton-estado" style="background-color: #28a745;">Ya Registrado</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="boton-registrarse">Iniciar Sesión para Registrarse</a>
                @endauth
            </div>
        </div>

        <!-- Descripción del Evento -->
        <div class="tarjeta">
            <h3 class="titulo-tarjeta">Descripción del Evento</h3>
            <p class="descripcion-evento">{{ $event->description }}</p>

            <div class="cuadricula-detalles">
                <!-- Premios -->
                @if($event->prizes)
                <div class="seccion-detalles">
                    <h4 class="titulo-detalles">
                        <svg class="icono-copita" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                            <path d="M4 22h16" />
                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                        </svg>
                        Premios
                    </h4>
                    <ul class="lista-premios">
                        @foreach($event->prizes as $index => $prize)
                        <li>
                            @if($index === 0)
                                <svg class="medalla-oro" width="16" height="16" viewBox="0 0 24 24" fill="gold" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <text x="12" y="16" font-size="12" text-anchor="middle" fill="black">1</text>
                                </svg>
                            @elseif($index === 1)
                                <svg class="medalla-plata" width="16" height="16" viewBox="0 0 24 24" fill="silver" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <text x="12" y="16" font-size="12" text-anchor="middle" fill="black">2</text>
                                </svg>
                            @else
                                <svg class="medalla-bronce" width="16" height="16" viewBox="0 0 24 24" fill="#CD7F32" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <text x="12" y="16" font-size="12" text-anchor="middle" fill="black">3</text>
                                </svg>
                            @endif
                            {{ $prize }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Requisitos -->
                @if($event->requirements)
                <div class="seccion-detalles">
                    <h4 class="titulo-detalles">
                        <svg class="listita-papeles" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                            <line x1="9" y1="11" x2="15" y2="11" />
                        </svg>
                        Requisitos
                    </h4>
                    <ul class="lista-requisitos">
                        @foreach($event->requirements as $requirement)
                        <li>{{ $requirement }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Sección de Equipos -->
        <div class="tarjeta">
            <h3 class="titulo-tarjeta">
                <svg class="grupito-personas" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Equipos Participantes ({{ $event->teams->count() }})
            </h3>

            @forelse($event->teams as $team)
            <!-- Tarjeta de Equipo -->
            <div class="tarjeta-equipo">
                <div class="cabecera-equipo">
                    <div>
                        <h4 class="nombre-equipo">{{ $team->name }}</h4>
                        <p class="descripcion-equipo">{{ $team->description }}</p>
                    </div>
                    <div class="botones-equipo">
                        <a href="{{ route('teams.show', $team) }}" class="boton-secundario">Ver Equipo</a>
                        @auth
                            @if($team->isRecruiting() && !$team->hasMember(Auth::user()))
                            <form action="{{ route('teams.join', $team) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="boton-secundario">
                                    <svg class="iconito-usuario" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Solicitar Unirse
                                </button>
                            </form>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="miembros-equipo">
                    <div class="columna-miembros">
                        <h5 class="titulo-columna">Miembros Actuales</h5>
                        @foreach($team->activeMembers as $member)
                        <div class="miembro">
                            <span class="nombre-miembro">{{ $member->name }}</span>
                            <span class="etiqueta etiqueta-programador">{{ $member->pivot->role }}</span>
                            @if($member->pivot->specialization)
                            <span class="rol-miembro">{{ $member->pivot->specialization }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($team->available_roles && count($team->available_roles) > 0)
                    <div class="columna-miembros">
                        <h5 class="titulo-columna">Roles Disponibles</h5>
                        <div class="roles-disponibles">
                            @foreach($team->available_roles as $role)
                            <span class="etiqueta-rol">{{ $role }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <p style="color: var(--color-texto-secundario); text-align: center; padding: 2rem;">
                Aún no hay equipos registrados. ¡Sé el primero en crear uno!
            </p>
            @endforelse
        </div>
    </section>

    <!-- Barra Lateral Derecha -->
    <aside class="barrita-lateral">
        <!-- Cronograma -->
        @if($event->schedule)
        <div class="tarjeta-lateral">
            <h3 class="titulo-lateral">Cronograma</h3>
            <div class="linea-tiempo">
                @foreach($event->schedule as $item)
                <div class="item-tiempo">
                    <span class="puntito-tiempo"></span>
                    <span class="texto-tiempo">{{ $item['name'] }}</span>
                    <span class="fecha-tiempo">{{ $item['date'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Acciones -->
        <div class="tarjeta-lateral">
            <h3 class="titulo-lateral">Acciones</h3>
            @auth
            <a href="{{ route('teams.create', ['event' => $event->id]) }}" class="boton-accion boton-primario">
                <svg class="simbolito-mas" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Crear Nuevo Equipo
            </a>
            @endauth
            <a href="{{ route('teams.index', ['event' => $event->id]) }}" class="boton-accion">
                <svg class="iconitos-grupito" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Explorar Equipos
            </a>
            @if($event->resources_url)
            <a href="{{ $event->resources_url }}" class="boton-accion" target="_blank">
                <svg class="flechita-descarga" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Descargar Recursos
            </a>
            @endif
        </div>

        <!-- Información del Evento -->
        <div class="tarjeta-lateral">
            <h3 class="titulo-lateral">Información del Evento</h3>
            <div class="lista-informacion">
                <div class="item-informacion">
                    <span class="etiqueta-informacion">Participantes</span>
                    <span class="valor-informacion">{{ $event->total_participants }}</span>
                </div>
                <div class="item-informacion">
                    <span class="etiqueta-informacion">Equipos Máximo</span>
                    <span class="valor-informacion">{{ $event->max_team_members }} Miembros</span>
                </div>
                <div class="item-informacion">
                    <span class="etiqueta-informacion">Tipo</span>
                    <span class="valor-informacion">{{ ucfirst($event->type) }}</span>
                </div>
                <div class="item-informacion">
                    <span class="etiqueta-informacion">Estado</span>
                    <span class="etiqueta etiqueta-abierto">{{ ucfirst($event->status) }}</span>
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection