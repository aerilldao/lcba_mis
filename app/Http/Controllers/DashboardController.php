<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CalendarEvent;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function updateNotes(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        Auth::user()->update([
            'quick_notes' => $request->notes,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function getEvents(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $events = CalendarEvent::where('user_id', Auth::id())
            ->whereMonth('event_date', $request->month)
            ->whereYear('event_date', $request->year)
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->get();

        return response()->json($events);
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'color' => 'nullable|string|max:20',
        ]);

        $event = CalendarEvent::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'color' => $request->color ?? '#3b82f6',
        ]);

        return response()->json($event, 201);
    }

    public function updateEvent(Request $request, CalendarEvent $event)
    {
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'color' => 'nullable|string|max:20',
        ]);

        $event->update($request->only(['title', 'description', 'event_date', 'event_time', 'color']));

        return response()->json($event);
    }

    public function deleteEvent(CalendarEvent $event)
    {
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['status' => 'deleted']);
    }
}
