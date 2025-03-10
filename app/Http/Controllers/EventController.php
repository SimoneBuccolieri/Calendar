<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())->orderBy('start_time')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'color' => 'required',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => auth()->id(),
            'color' => $request->color,
        ]);

        $view = session('calendar_view', 'week');
        if ($view === 'week') {
            return redirect()->route('calendar.week');
        } elseif ($view === 'month') {
            return redirect()->route('calendar.month');
        }
        return redirect()->route('events.index')
            ->with('success', 'Evento aggiunto con successo!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        $view = session('calendar_view', 'week');
        if ($view === 'week') {
            return redirect()->route('calendar.week');
        } elseif ($view === 'month') {
            return redirect()->route('calendar.month');
        }
        return redirect()->route('events.index')
            ->with('success', 'Evento aggiunto con successo!');
    }
    public function show(Event $event){
        return view('events.show', compact('event'));
    }
    public function edit(Event $event){
        return view('events.edit', compact('event'));
    }
    public function update(Request $request, Event $event){
        $validatedData=$request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'color' => 'required',
        ]);
        $event->update($validatedData);

        $view = session('calendar_view', 'week');
        if ($view === 'week') {
            return redirect()->route('calendar.week');
        } elseif ($view === 'month') {
            return redirect()->route('calendar.month');
        }
        return redirect()->route('events.index')
            ->with('success', 'Evento aggiunto con successo!');
    }
}
