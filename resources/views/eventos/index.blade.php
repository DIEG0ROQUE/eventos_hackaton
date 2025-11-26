<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($eventos as $evento)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                @if($evento->imagen_portada)
                                    <img src="{{ asset('storage/' . $evento->imagen_portada) }}" 
                                         alt="{{ $evento->titulo }}"
                                         class="w-full h-48 object-cover rounded mb-4">
                                @endif
                                
                                <h3 class="text-xl font-bold mb-2">{{ $evento->titulo }}</h3>
                                
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $evento->tipoTexto }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                        {{ $evento->estadoTexto }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4">
                                    {{ Str::limit($evento->descripcion, 100) }}
                                </p>
                                
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <!-- Fecha -->
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $evento->fecha_inicio->format('d/m/Y') }}</span>
                                    </div>
                                    
                                    <!-- Ubicación -->
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $evento->ubicacion }}</span>
                                    </div>
                                    
                                    <!-- Participantes -->
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                        </svg>
                                        <span>{{ $evento->totalParticipantes() }} participantes</span>
                                    </div>
                                    
                                    <!-- Equipos -->
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                        </svg>
                                        <span>{{ $evento->totalEquipos() }} equipos</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('eventos.show', $evento) }}" 
                                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Ver Detalles
                                </a>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12">
                                <p class="text-gray-500 text-lg">No hay eventos disponibles</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-6">
                        {{ $eventos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>