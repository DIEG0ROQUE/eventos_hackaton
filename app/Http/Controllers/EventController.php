<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Mostrar lista de eventos
     */
    public function index()
    {
        $events = Event::with(['teams', 'registrations'])
            ->active()
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        return view('events.index', compact('events'));
    }

    /**
     * Mostrar detalles de un evento
     */
    public function show(Event $event)
    {
        // Cargar relaciones necesarias
        $event->load([
            'teams.activeMembers',
            'teams.leader',
            'registrations'
        ]);

        // Verificar si el usuario actual está registrado
        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = $event->registrations()
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('events.show', compact('event', 'isRegistered'));
    }

    /**
     * Registrar usuario a un evento
     */
    public function register(Request $request, Event $event)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para registrarte.');
        }

        // Verificar que el evento esté abierto
        if (!$event->isOpen()) {
            return redirect()->back()
                ->with('error', 'Este evento no está abierto para registro.');
        }

        // Verificar si ya está registrado
        $existingRegistration = EventRegistration::where([
            'event_id' => $event->id,
            'user_id' => Auth::id()
        ])->first();

        if ($existingRegistration) {
            return redirect()->back()
                ->with('error', 'Ya estás registrado en este evento.');
        }

        // Crear registro
        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'status' => 'registered',
            'registered_at' => now()
        ]);

        return redirect()->back()
            ->with('success', '¡Te has registrado exitosamente al evento!');
    }

    /**
     * Cancelar registro a un evento
     */
    public function cancelRegistration(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = EventRegistration::where([
            'event_id' => $event->id,
            'user_id' => Auth::id()
        ])->first();

        if (!$registration) {
            return redirect()->back()
                ->with('error', 'No estás registrado en este evento.');
        }

        $registration->update(['status' => 'cancelled']);

        return redirect()->back()
            ->with('success', 'Has cancelado tu registro al evento.');
    }

    /**
     * Mostrar formulario de creación (para administradores)
     */
    public function create()
    {
        // Verificar permisos de administrador
        // $this->authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Guardar nuevo evento
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'duration_hours' => 'required|integer|min:1',
            'max_teams' => 'nullable|integer|min:1',
            'max_team_members' => 'required|integer|min:1|max:10',
            'type' => 'required|string',
            'prizes' => 'nullable|array',
            'requirements' => 'nullable|array',
            'schedule' => 'nullable|array',
            'resources_url' => 'nullable|url',
        ]);

        // Crear evento
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Event $event)
    {
        // Verificar permisos
        // $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Actualizar evento
     */
    public function update(Request $request, Event $event)
    {
        // Validar y actualizar
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'duration_hours' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,in_progress,closed,completed',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Eliminar evento
     */
    public function destroy(Event $event)
    {
        // Verificar permisos
        // $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Evento eliminado exitosamente.');
    }
}