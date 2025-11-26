<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Models\Carrera;
use App\Models\Habilidad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Mostrar perfil público del usuario
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $user->load(['participante.carrera', 'roles']);

        // Obtener estadísticas si es participante
        $stats = null;
        if ($user->participante) {
            $stats = [
                'eventos' => $user->participante->equipos()
                    ->distinct('evento_id')
                    ->count('evento_id'),
                'equipos' => $user->participante->equipos()->count(),
                'proyectos' => $user->participante->equipos()
                    ->whereHas('proyecto')
                    ->count(),
                'constancias' => $user->participante->constancias()->count(),
            ];
        }

        return view('profile.show', compact('user', 'stats'));
    }

    /**
     * Formulario para editar perfil
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('participante.carrera');
        $carreras = Carrera::all();

        return view('profile.edit', compact('user', 'carreras'));
    }

    /**
     * Actualizar información del perfil
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'carrera_id' => 'nullable|exists:carreras,id',
            'no_control' => 'nullable|string|max:20|unique:participantes,no_control,' . ($user->participante?->id ?? 'NULL'),
            'semestre' => 'nullable|integer|min:1|max:12',
            'telefono' => 'nullable|string|max:15',
            'biografia' => 'nullable|string|max:500',
        ]);

        // Actualizar usuario
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Actualizar o crear participante si es necesario
        if ($user->isParticipante()) {
            if ($user->participante) {
                $user->participante->update([
                    'carrera_id' => $validated['carrera_id'] ?? $user->participante->carrera_id,
                    'no_control' => $validated['no_control'] ?? $user->participante->no_control,
                    'semestre' => $validated['semestre'] ?? $user->participante->semestre,
                    'telefono' => $validated['telefono'] ?? $user->participante->telefono,
                    'biografia' => $validated['biografia'] ?? $user->participante->biografia,
                ]);
            }
        }

        return redirect()->route('profile.show')
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * Eliminar cuenta
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada.');
    }

    /**
     * Mostrar formulario para completar perfil de participante
     */
    public function complete(): View
    {
        $carreras = Carrera::all();
        return view('profile.complete', compact('carreras'));
    }

    /**
     * Guardar perfil completo de participante
     */
    public function storeComplete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'carrera_id' => 'required|exists:carreras,id',
            'no_control' => 'required|string|max:20|unique:participantes,no_control',
            'semestre' => 'required|integer|min:1|max:12',
            'telefono' => 'nullable|string|max:15',
            'biografia' => 'nullable|string|max:500',
        ]);

        // Crear perfil de participante
        Participante::create([
            'user_id' => auth()->id(),
            'carrera_id' => $validated['carrera_id'],
            'no_control' => $validated['no_control'],
            'semestre' => $validated['semestre'],
            'telefono' => $validated['telefono'] ?? null,
            'biografia' => $validated['biografia'] ?? 'Estudiante apasionado por la tecnología.',
        ]);

        return redirect()->route('dashboard')
            ->with('success', '¡Perfil completado exitosamente! Ahora puedes participar en eventos.');
    }

    /**
     * Agregar nueva habilidad
     */
    public function storeHabilidad(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'nivel' => 'required|integer|min:0|max:100',
            'color' => 'required|string|max:50',
        ]);

        $participante = auth()->user()->participante;

        if (!$participante) {
            return back()->with('error', 'Debes completar tu perfil primero.');
        }

        // Obtener el último orden
        $ultimoOrden = $participante->habilidades()->max('orden') ?? 0;

        Habilidad::create([
            'participante_id' => $participante->id,
            'nombre' => $validated['nombre'],
            'nivel' => $validated['nivel'],
            'color' => $validated['color'],
            'orden' => $ultimoOrden + 1,
        ]);

        return back()->with('success', 'Habilidad agregada exitosamente.');
    }

    /**
     * Actualizar habilidad existente
     */
    public function updateHabilidad(Request $request, Habilidad $habilidad): RedirectResponse
    {
        // Verificar que la habilidad pertenece al usuario
        if ($habilidad->participante_id !== auth()->user()->participante->id) {
            abort(403, 'No puedes editar esta habilidad.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'nivel' => 'required|integer|min:0|max:100',
            'color' => 'required|string|max:50',
        ]);

        $habilidad->update($validated);

        return back()->with('success', 'Habilidad actualizada exitosamente.');
    }

    /**
     * Eliminar habilidad
     */
    public function destroyHabilidad(Habilidad $habilidad): RedirectResponse
    {
        // Verificar que la habilidad pertenece al usuario
        if ($habilidad->participante_id !== auth()->user()->participante->id) {
            abort(403, 'No puedes eliminar esta habilidad.');
        }

        $habilidad->delete();

        return back()->with('success', 'Habilidad eliminada exitosamente.');
    }
}
