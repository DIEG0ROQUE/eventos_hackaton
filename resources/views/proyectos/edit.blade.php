<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('equipos.show', $equipo) }}" 
                           class="text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                Editar Proyecto
                            </h2>
                            <p class="text-gray-600 mt-1">
                                {{ $proyecto->nombre }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <form method="POST" action="{{ route('proyectos.update', $equipo) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Resto del formulario igual que create.blade.php pero con valores prellenados -->
                        
                        <!-- Nombre del Proyecto -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Proyecto <span class="text-red-500">*</span>
                            </label>
                            <input id="nombre" type="text" name="nombre" 
                                   value="{{ old('nombre', $proyecto->nombre) }}" required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción del Proyecto <span class="text-red-500">*</span>
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="6" required
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tecnologías -->
                        <div>
                            <label for="tecnologias" class="block text-sm font-medium text-gray-700 mb-2">
                                Tecnologías Utilizadas
                            </label>
                            <input id="tecnologias" type="text" name="tecnologias" 
                                   value="{{ old('tecnologias', $proyecto->tecnologias) }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <!-- Links -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Enlaces del Proyecto</h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="link_repositorio" class="block text-sm font-medium text-gray-700 mb-2">Repositorio</label>
                                    <input id="link_repositorio" type="url" name="link_repositorio" 
                                           value="{{ old('link_repositorio', $proyecto->link_repositorio) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="link_demo" class="block text-sm font-medium text-gray-700 mb-2">Demo en Vivo</label>
                                    <input id="link_demo" type="url" name="link_demo" 
                                           value="{{ old('link_demo', $proyecto->link_demo) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="link_presentacion" class="block text-sm font-medium text-gray-700 mb-2">Presentación</label>
                                    <input id="link_presentacion" type="url" name="link_presentacion" 
                                           value="{{ old('link_presentacion', $proyecto->link_presentacion) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('equipos.show', $equipo) }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition shadow-lg">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
