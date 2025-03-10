<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function weekView(Request $request)
    {
        $date = $request->has('date')
            ? Carbon::parse($request->date)
            : Carbon::parse(session('date', now()->toDateString()));

        // Salva in sessione la modalità e la data scelta
        session(['calendar_view' => 'week', 'date' => $date->toDateString()]);
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        $events = Event::where(function ($query) use ($startOfWeek, $endOfWeek) {
            $query->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                ->orWhereBetween('end_time', [$startOfWeek, $endOfWeek])
                ->orWhere(function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->where('start_time', '<', $startOfWeek)
                        ->where('end_time', '>', $endOfWeek);
                });
        })  ->where('user_id', auth()->id())
            ->orderBy('start_time')
            ->get();

        $calendar = [];

        foreach ($events as $event) {
            $eventStart = $event->start_time instanceof Carbon ? $event->start_time : Carbon::parse($event->start_time);
            $eventEnd = $event->end_time instanceof Carbon ? $event->end_time : Carbon::parse($event->end_time);

            for ($currentDay = $eventStart->copy(); $currentDay->lte($eventEnd); $currentDay->addDay()) {
                $dayIndex = ($currentDay->dayOfWeek + 6) % 7; // Convertire per settimana da Lunedì
                $hourIndex = $currentDay->isSameDay($eventStart) ? $eventStart->hour : 0;

                if (!isset($calendar[$dayIndex])) {
                    $calendar[$dayIndex] = [];
                }
                if (!isset($calendar[$dayIndex][$hourIndex])) {
                    $calendar[$dayIndex][$hourIndex] = [];
                }

                $calendar[$dayIndex][$hourIndex][] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'color' => $event->color,
                    'start_time' => $eventStart->toDateTimeString(),
                    'end_time' => $eventEnd->toDateTimeString(),
                    'duration' => $eventStart->diffInMinutes($eventEnd),
                    'isMultiDay' => !$eventStart->isSameDay($eventEnd),
                    'isStartDay' => $currentDay->isSameDay($eventStart),
                    'isEndDay' => $currentDay->isSameDay($eventEnd),
                ];
            }
        }

        return view('calendar.week', compact('date', 'calendar'));
    }
    public function monthView(Request $request)
    {
        $date = $request->has('date')
            ? Carbon::parse($request->date)
            : Carbon::parse(session('date', now()->toDateString()));

        session(['calendar_view' => 'month', 'date' => $date->toDateString()]);

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $events = Event::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('start_time', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('end_time', [$startOfMonth, $endOfMonth])
                ->orWhere(function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->where('start_time', '<', $startOfMonth)
                        ->where('end_time', '>', $endOfMonth);
                });
        })->where('user_id', auth()->id())
            ->orderBy('start_time')
            ->get();

        // Creiamo un array per il calendario mensile, raggruppando gli eventi per giorno
        $calendar = [];
        foreach ($events as $event) {
            $eventStart = $event->start_time instanceof Carbon ? $event->start_time : Carbon::parse($event->start_time);
            $eventEnd   = $event->end_time instanceof Carbon ? $event->end_time : Carbon::parse($event->end_time);

            // Per eventi multi-giorno, itera su ogni giorno che tocca l'evento
            for ($currentDay = $eventStart->copy(); $currentDay->lte($eventEnd); $currentDay->addDay()) {
                // Considera solo i giorni compresi nel mese corrente
                if ($currentDay->between($startOfMonth, $endOfMonth)) {
                    $dayKey = $currentDay->toDateString();
                    if (!isset($calendar[$dayKey])) {
                        $calendar[$dayKey] = [];
                    }
                    $calendar[$dayKey][] = [
                        'id'          => $event->id,
                        'title'       => $event->title,
                        'description' => $event->description,
                        'color'       => $event->color,
                        'start_time'  => $eventStart->toDateTimeString(),
                        'end_time'    => $eventEnd->toDateTimeString(),
                        'duration'    => $eventStart->diffInMinutes($eventEnd),
                        'isMultiDay'  => $eventStart->toDateString() !== $eventEnd->toDateString(),
                        'isStartDay'  => $currentDay->isSameDay($eventStart),
                        'isEndDay'    => $currentDay->isSameDay($eventEnd),
                    ];
                }
            }
        }

        return view('calendar.month', compact('date', 'calendar'));
    }

}
