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
                                Registrar Proyecto
                            </h2>
                            <p class="text-gray-600 mt-1">
                                Equipo: {{ $equipo->nombre }} | Evento: {{ $equipo->evento->nombre }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <form method="POST" action="{{ route('proyectos.store', $equipo) }}" class="space-y-6">
                        @csrf

                        <!-- Nombre del Proyecto -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Proyecto <span class="text-red-500">*</span>
                            </label>
                            <input id="nombre" 
                                   type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}"
                                   required
                                   placeholder="EduAI - Tutor Virtual Inteligente"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción del Proyecto <span class="text-red-500">*</span>
                            </label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      rows="6"
                                      required
                                      placeholder="Describe tu proyecto: ¿Qué problema resuelve? ¿Qué tecnologías usa? ¿Qué lo hace innovador?"
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Máximo 1000 caracteres
                            </p>
                        </div>

                        <!-- Tecnologías -->
                        <div>
                            <label for="tecnologias" class="block text-sm font-medium text-gray-700 mb-2">
                                Tecnologías Utilizadas <span class="text-gray-400 text-xs">(Opcional)</span>
                            </label>
                            <input id="tecnologias" 
                                   type="text" 
                                   name="tecnologias" 
                                   value="{{ old('tecnologias') }}"
                                   placeholder="React, Node.js, MongoDB, Python, TensorFlow..."
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tecnologias') border-red-500 @enderror">
                            @error('tecnologias')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Links -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Enlaces del Proyecto
                            </h3>

                            <!-- Repositorio -->
                            <div class="mb-4">
                                <label for="link_repositorio" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Repositorio (GitHub, GitLab, etc.)
                                    </div>
                                </label>
                                <input id="link_repositorio" 
                                       type="url" 
                                       name="link_repositorio" 
                                       value="{{ old('link_repositorio') }}"
                                       placeholder="https://github.com/usuario/proyecto"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('link_repositorio') border-red-500 @enderror">
                                @error('link_repositorio')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Demo -->
                            <div class="mb-4">
                                <label for="link_demo" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                        </svg>
                                        Demo en Vivo
                                    </div>
                                </label>
                                <input id="link_demo" 
                                       type="url" 
                                       name="link_demo" 
                                       value="{{ old('link_demo') }}"
                                       placeholder="https://mi-proyecto-demo.com"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('link_demo') border-red-500 @enderror">
                                @error('link_demo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Presentación -->
                            <div>
                                <label for="link_presentacion" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                        Presentación / Pitch Deck
                                    </div>
                                </label>
                                <input id="link_presentacion" 
                                       type="url" 
                                       name="link_presentacion" 
                                       value="{{ old('link_presentacion') }}"
                                       placeholder="https://docs.google.com/presentation/..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('link_presentacion') border-red-500 @enderror">
                                @error('link_presentacion')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <span class="font-medium">Consejos:</span>
                                    </p>
                                    <ul class="mt-2 text-sm text-blue-600 list-disc list-inside space-y-1">
                                        <li>Describe claramente el problema que resuelve tu proyecto</li>
                                        <li>Incluye capturas de pantalla o videos en tu repositorio</li>
                                        <li>Asegúrate de que todos los links sean accesibles públicamente</li>
                                        <li>Podrás editar esta información más adelante</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('equipos.show', $equipo) }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                                Registrar Proyecto
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
