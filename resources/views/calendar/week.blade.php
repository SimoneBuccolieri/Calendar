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
                    <a href="{{ route('calendar.week', ['date' => $date->copy()->subWeek()->toDateString()]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-8 md:h-10 px-1 md:px-4 md:py-2 text-xs md:text-base">
                        &laquo; Week
                    </a>
                    <a href="{{ route('calendar.week', ['date' => today()->copy()->toDateString()]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-8 md:h-10 px-1 md:px-4 md:py-2 text-xs md:text-base">
                        Today
                    </a>
                    <a href="{{ route('calendar.week', ['date' => $date->copy()->addWeek()->toDateString()]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 px-1 h-8 md:h-10 px-1 md:px-4 md:py-2 text-xs md:text-base">
                        Week &raquo;
                    </a>
                    <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium border border-gray-200 bg-black hover:bg-black/90 h-8 md:h-10 px-1 md:px-4 py-2 text-xs md:text-base">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r0:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-4 w-4 mr-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Add Event</button>
                    </a>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg ">
                <div class="overflow-x-auto">
                <div class="grid grid-cols-[auto_1fr] divide-x w-full md:w-auto ">
                    <div class="divide-y border-gray-200">
                        <div class="p-2 h-12 md:h-20 text-center font-medium border-r border-gray-200 bg-gray-200"></div>

                        @foreach(range(0, 23) as $hour)
                            <div class="md:p-2 border-gray-200 text-xs sm:text-sm text-right pr-2 sm:pr-4 h-10 md:h-20 sm:h-20 flex items-center justify-end whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-3 w-3 mr-1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <p>{{$hour}}:00</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7 divide-x w-full ">
                        @foreach(range(0, 6) as $i)
                            @php
                                $currentDay = $date->startOfWeek()->copy()->addDays($i);
                            @endphp
                            <div class="p-2 h-12 md:h-20 text-center font-medium border-b border-gray-200 relative">
                                <div class="text-xs md:text-sm">{{ $currentDay->translatedFormat('D') }}</div>
                                <div class="text-sm md:text-lg">{{ $currentDay->format('d') }}</div>
                                @if($currentDay == today())
                                    <div class="absolute top-0 rounded-2xl text-white bg-blue-800 px-1 text-xs md:text-sm">Oggi</div>
                                @endif
                            </div>
                        @endforeach
                        @foreach(range(0, 6) as $dayIndex)

                            <div class="divide-y border-gray-200">
                                @foreach(range(0, 23) as $hourIndex)
                                    <div class="p-1 h-10 md:h-20 relative border-gray-200  ">
                                        @foreach($calendar[$dayIndex][$hourIndex] ?? [] as $event)
                                            @php
                                                $isStartDay = $event['isStartDay'];
                                                $isEndDay   = $event['isEndDay'];
                                                $eventStart = \Carbon\Carbon::parse($event['start_time']);
                                                $eventEnd   = \Carbon\Carbon::parse($event['end_time']);
                                                $bgcolor = $event['color'];

                                                // Se l'evento inizia oggi, calcola l'offset verticale in base ai minuti,
                                                // altrimenti inizia dall'inizio della cella (0)
                                                $topOffset = $isStartDay ? ($eventStart->minute * 100) / 60 : 0;

                                                // Calcola la durata visibile in questa cella:
                                                if ($isStartDay && $isEndDay) {
                                                    // Evento contenuto in un'unica cella
                                                    $visibleDuration = $event['duration'];
                                                } elseif ($isStartDay) {
                                                    // Inizio evento: dalla partenza fino al termine dell'ora (o della cella)
                                                    $visibleDuration = 1440 - ($eventStart->hour*60 + $eventStart->minute);
                                                } elseif ($isEndDay) {
                                                    // Fine evento: dall'inizio della cella fino ai minuti finali
                                                    $visibleDuration = $eventEnd->hour*60 + $eventEnd->minute;
                                                } else {
                                                    // Giorni intermedi: copre tutta la cella oraria
                                                    $visibleDuration = 1440;
                                                }
                                                $heightPercent = ($visibleDuration * 100) / 60;
                                            @endphp

                                            <a href="{{route('events.show', ['event' => $event['id']])}}">
                                            <div class="absolute left-0 right-0 md:left-2 md:right-2 text-white p-2 rounded-lg shadow-md z-20 border border-white md:min-h-fit overflow-x-hidden overflow-y-hidden"
                                                 style="top: calc({{ $topOffset }}%); height: calc({{ $heightPercent }}%);background-color: {{$bgcolor}}">
                                                <p class="text-[9px] md:text-xs md:font-bold break-words">{{ $event['title'] }}</p>
                                                <p class="hidden md:block text-xs">{{ $eventStart->format('H:i') }} - {{ $eventEnd->format('H:i') }}</p>
                                            </div></a>
                                        @endforeach


                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
            <div class="flex justify-end">
                <a href="{{route('calendar.month', ['date' => $date->copy()->toDateString()])}}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm text-white font-medium border border-gray-200 bg-black hover:bg-black/90 h-10 px-1 md:px-4 py-2 text-xs md:text-base">Month View</a>
            </div>
        </div>

    </div>

@endsection
