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

        // Local Events
        $events = CalendarEvent::where('user_id', Auth::id())
            ->whereMonth('event_date', $request->month)
            ->whereYear('event_date', $request->year)
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->get()
            ->map(function($ev) {
                $ev->source = 'local';
                return $ev;
            });

        // Google Calendar Integration
        $googleId = env('GOOGLE_CALENDAR_ID');
        $googleKey = env('GOOGLE_API_KEY');

        if ($googleId && $googleKey) {
            try {
                $startOfMonth = sprintf('%04d-%02d-01T00:00:00Z', $request->year, $request->month);
                $endOfMonth = sprintf('%04d-%02d-%02dT23:59:59Z', $request->year, $request->month, cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year));
                
                $url = "https://www.googleapis.com/content/v3/calendars/" . urlencode($googleId) . "/events?key=" . $googleKey . "&timeMin=" . $startOfMonth . "&timeMax=" . $endOfMonth . "&singleEvents=true";
                
                $response = file_get_contents($url);
                if ($response) {
                    $googleData = json_decode($response, true);
                    if (isset($googleData['items'])) {
                        foreach ($googleData['items'] as $item) {
                            $date = isset($item['start']['date']) ? $item['start']['date'] : substr($item['start']['dateTime'], 0, 10);
                            $time = isset($item['start']['dateTime']) ? substr($item['start']['dateTime'], 11, 5) : null;
                            
                            $events->push((object)[
                                'id' => 'google_' . $item['id'],
                                'title' => $item['summary'] ?? '(No Title)',
                                'description' => $item['description'] ?? null,
                                'event_date' => $date,
                                'event_time' => $time,
                                'color' => '#4285F4', // Google Blue
                                'source' => 'google',
                                'htmlLink' => $item['htmlLink'] ?? null
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silently fail or log if Google fetch fails
            }
        }

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
