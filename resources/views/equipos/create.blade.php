<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Crear Equipo
                    </h2>
                    <p class="text-gray-600">
                        Crea tu equipo para {{ $evento->nombre }}
                    </p>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <form method="POST" action="{{ route('equipos.store', $evento) }}" class="space-y-6">
                        @csrf

                        <!-- Nombre del Equipo -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Equipo <span class="text-red-500">*</span>
                            </label>
                            <input id="nombre" 
                                   type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}"
                                   required
                                   placeholder="Los Innovadores"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Elige un nombre único que identifique a tu equipo
                            </p>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción <span class="text-gray-400 text-xs">(Opcional)</span>
                            </label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      rows="3"
                                      placeholder="Describe brevemente tu equipo y tu proyecto..."
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tu Perfil en el Equipo -->
                        <div>
                            <label for="perfil_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tu Rol en el Equipo <span class="text-red-500">*</span>
                            </label>
                            <select id="perfil_id" 
                                    name="perfil_id" 
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('perfil_id') border-red-500 @enderror">
                                <option value="">Selecciona tu rol</option>
                                @foreach($perfiles as $perfil)
                                    <option value="{{ $perfil->id }}" {{ old('perfil_id') == $perfil->id ? 'selected' : '' }}>
                                        {{ $perfil->nombre }}
                                        @if($perfil->descripcion)
                                            - {{ $perfil->descripcion }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('perfil_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Selecciona el rol que desempeñarás en el equipo
                            </p>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <span class="font-medium">Información importante:</span>
                                    </p>
                                    <ul class="mt-2 text-sm text-blue-600 list-disc list-inside space-y-1">
                                        <li>Serás el líder del equipo automáticamente</li>
                                        <li>Tamaño del equipo: {{ $evento->min_miembros_equipo }} a {{ $evento->max_miembros_equipo }} miembros</li>
                                        <li>Podrás invitar a más miembros después de crear el equipo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('eventos.show', $evento) }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                                Crear Equipo
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
