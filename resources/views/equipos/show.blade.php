<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $equipo->nombre }}</h1>
                        <p class="text-gray-600 mb-2">{{ $equipo->evento->nombre }}</p>
                        <p class="text-sm text-gray-500">Líder: {{ $equipo->lider->user->name }} • {{ $equipo->totalMiembros() }} miembros</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Configurar
                        </button>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Invitar
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Columna Izquierda (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Miembros del Equipo -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                Miembros del Equipo
                            </h3>
                            <span class="text-sm text-gray-500">{{ $equipo->totalMiembros() }}/{{ $equipo->max_miembros }}</span>
                        </div>

                        <div class="space-y-3">
                            @foreach($equipo->miembrosActivos()->get() as $miembro)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($miembro->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-gray-900">{{ $miembro->user->name }}</span>
                                                @if($equipo->lider_id == $miembro->id)
                                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">LÍDER</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-600">{{ $miembro->carrera->nombre }}</div>
                                            <div class="text-sm text-indigo-600 font-medium">{{ $miembro->pivot->perfil->nombre ?? 'Sin perfil' }}</div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">Se unió: {{ $miembro->pivot->created_at->format('d M Y') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Roles Disponibles -->
                        @if($equipo->puedeAceptarMiembros())
                            <div class="mt-4 pt-4 border-t">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Roles Disponibles</h4>
                                <div class="text-sm text-gray-600">
                                    Analista de Negocios
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Progreso del Proyecto -->
                    @if($equipo->proyecto)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    Progreso del Proyecto
                                </h3>
                                <a href="{{ route('proyectos.edit', $equipo) }}" class="text-sm text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Ver Detalles
                                </a>
                            </div>

                            @php
                                $tareas = $equipo->proyecto->tareas ?? collect([
                                    (object)['nombre' => 'Definición de requisitos', 'asignado' => 'Ana García', 'estado' => 'completada'],
                                    (object)['nombre' => 'Diseño de interfaz', 'asignado' => 'Luis Martín', 'estado' => 'en_progreso'],
                                    (object)['nombre' => 'Desarrollo backend', 'asignado' => 'Ana García', 'estado' => 'en_progreso'],
                                    (object)['nombre' => 'Análisis de datos', 'asignado' => 'María López', 'estado' => 'pendiente'],
                                    (object)['nombre' => 'Presentación final', 'asignado' => 'Equipo', 'estado' => 'pendiente'],
                                ]);
                            @endphp

                            <div class="space-y-3">
                                @foreach($tareas as $tarea)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="w-8 h-8 rounded flex items-center justify-center
                                                @if($tarea->estado == 'completada') bg-green-100 text-green-600
                                                @elseif($tarea->estado == 'en_progreso') bg-purple-100 text-purple-600
                                                @else bg-gray-100 text-gray-400 @endif">
                                                @if($tarea->estado == 'completada')
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-900">{{ is_object($tarea) ? $tarea->nombre : $tarea['nombre'] }}</div>
                                                <div class="text-sm text-gray-500">Asignado a: {{ is_object($tarea) ? ($tarea->asignado ?? 'No asignado') : $tarea['asignado'] }}</div>
                                            </div>
                                        </div>
                                        @if($tarea->estado == 'completada')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Completada</span>
                                        @elseif($tarea->estado == 'en_progreso')
                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">En Progreso</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">Pendiente</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Columna Derecha (1/3) -->
                <div class="space-y-6">
                    
                    <!-- Chat del Equipo -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-4 border-b">
                            <h3 class="font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                Chat del Equipo
                            </h3>
                        </div>
                        
                        <div class="h-64 overflow-y-auto p-4 space-y-3" id="chat-messages">
                            @php
                                $mensajes = $equipo->mensajes()->with('participante.user')->latest()->take(20)->get()->reverse();
                            @endphp

                            @forelse($mensajes as $mensaje)
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ substr($mensaje->participante->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold">{{ explode(' ', $mensaje->participante->user->name)[0] }}</div>
                                        <div class="text-sm text-gray-700">{{ $mensaje->mensaje }}</div>
                                        <div class="text-xs text-gray-400">{{ $mensaje->created_at->format('g:i A') }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-400 py-8">
                                    <p class="text-sm">No hay mensajes aún</p>
                                    <p class="text-xs">Sé el primero en enviar un mensaje</p>
                                </div>
                            @endforelse
                        </div>

                        @if($esMiembro)
                            <form method="POST" action="{{ route('equipos.enviar-mensaje', $equipo) }}" class="p-4 border-t">
                                @csrf
                                <div class="flex gap-2">
                                    <input type="text" 
                                           name="mensaje" 
                                           placeholder="Escribe un mensaje..." 
                                           required
                                           class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Invitaciones Pendientes -->
                    @if($esLider)
                        @php
                            $pendientes = $equipo->participantes()->wherePivot('estado', 'pendiente')->get();
                        @endphp

                        @if($pendientes->count() > 0)
                            <div class="bg-white rounded-xl shadow-sm p-4">
                                <h3 class="font-bold mb-3">Invitaciones Pendientes</h3>
                                <div class="space-y-3">
                                    @foreach($pendientes as $solicitante)
                                        <div class="p-3 bg-yellow-50 rounded-lg">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                    {{ substr($solicitante->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-semibold text-sm">{{ $solicitante->user->name }}</div>
                                                    <div class="text-xs text-gray-600">{{ $solicitante->pivot->perfil->nombre ?? 'N/A' }}</div>
                                                </div>
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">Pendiente</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Estadísticas del Equipo -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-bold mb-3">Estadísticas del Equipo</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Progreso General</span>
                                    <span class="font-semibold">60%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tareas Completadas</span>
                                    <span class="font-semibold">1/5</span>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Días Restantes</span>
                                    <span class="font-semibold">12</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
