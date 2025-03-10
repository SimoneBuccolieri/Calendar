@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="flex flex-col space-y-6 ">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-6 w-6"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                    <h1 class="text-2xl font-bold mx-2 uppercase">{{$date->locale('it')->translatedFormat('F Y')}}</h1>
                </div>
                <div class="flex items-center space-x-0.5 md:space-x-2">
                    <a href="{{ route('calendar.month', ['date' => $date->copy()->subMonth()->toDateString()]) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-8 md:h-10 px-1 md:px-4 py-2 text-xs md:text-base">
                        &laquo; Month
                    </a>
                    <a href="{{ route('calendar.month', ['date' => today()->copy()->toDateString()]) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-8 md:h-10 px-1 md:px-4 py-2 text-xs md:text-base">
                        Today
                    </a>
                    <a href="{{ route('calendar.month', ['date' => $date->copy()->addMonth()->toDateString()]) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 px-1 h-8 md:h-10 px-1 md:px-4 py-2 text-xs md:text-base">
                        Month &raquo;
                    </a>
                    <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium border border-gray-200 bg-black hover:bg-black/90 h-8 md:h-10 px-1 md:px-4 py-2 text-xs md:text-base">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r0:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-4 w-4 mr-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Add Event</button>
                    </a>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-x-auto">
                <div class="grid grid-cols-7 gap-px ">
                    <div class="p-2 text-center text-sm">Lun</div>
                    <div class="p-2 text-center text-sm">Mar</div>
                    <div class="p-2 text-center text-sm">Mer</div>
                    <div class="p-2 text-center text-sm">Gio</div>
                    <div class="p-2 text-center text-sm">Ven</div>
                    <div class="p-2 text-center text-sm">Sab</div>
                    <div class="p-2 text-center text-sm">Dom</div>
                </div>
                @php
                    // Calcola l'inizio e la fine del calendario da visualizzare
                    $startOfMonth = $date->copy()->startOfMonth();
                    $endOfMonth = $date->copy()->endOfMonth();
                    // Imposta il primo giorno da visualizzare: inizia dalla settimana che contiene il primo del mese (assumendo settimana che inizia il lunedì)
                    $startOfCalendar = $startOfMonth->copy()->startOfWeek();
                    // Imposta l'ultimo giorno da visualizzare: termina alla fine della settimana che contiene l'ultimo giorno del mese
                    $endOfCalendar = $endOfMonth->copy()->endOfWeek();
                @endphp

                <div class="grid grid-cols-7 divide-x divide-y">
                    @for ($day = $startOfCalendar->copy(); $day->lte($endOfCalendar); $day->addDay())
                        <div class="md:p-2 pt-2 md:pt-0 h-24 md:h-32 lg:h-48 relative border border-gray-200 overflow-y-hidden relative">
                            @if($day == today())
                                <div class="absolute top-2 text-xs rounded-2xl text-white bg-gray-600 px-1">Oggi</div>
                            @endif
                            @if($day->month == $date->month)
                                <div class="absolute top-0 right-0 text-xs font-bold">{{ $day->format('d') }}</div>
                                @if(isset($calendar[$day->toDateString()]))
                                    @foreach($calendar[$day->toDateString()] as $event)
                                        <a href="{{ route('events.show', ['event' => $event['id']]) }}">
                                            <div class=" text-white my-1 p-1 rounded  text-[9px] md:text-xs break-words h-8 md:h-12 lg:h-16 overflow-hidden"
                                            style="background-color: {{$event['color']}}">
                                                {{ $event['title'] }}
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            @else
                                <div class="absolute top-0 right-0 text-xs text-gray-400">{{ $day->format('d') }}</div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
            <div class="flex justify-end">
                <a href="{{route('calendar.week', ['date' => $date->copy()->toDateString()])}}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium border border-gray-200 bg-black hover:bg-black/90 h-10 px-1 md:px-4 py-2 text-xs md:text-base">Week View</a>
            </div>

        </div>
    </div>
@endsection
