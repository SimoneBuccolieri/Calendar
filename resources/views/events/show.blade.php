@extends('layouts.app')
@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="card border shadow border-gray-200 bg-white rounded-xl p-4 my-4">
            <div class="flex flex-col">
                <h2 class="uppercase text-2xl font-bold">{{$event->title}}</h2>
                <div class="pl-4 p-2">
                    @if(!$event->start_time->isSameDay($event->end_time))
                        <div class="text-balance">{{$event->start_time->format('l j M')}} alle {{$event->start_time->format('H:i')}} -
                            {{$event->end_time->format('l j M')}} alle {{$event->end_time->format('H:i')}}</div>
                    @else
                        <div class="text-balance">{{$event->start_time->format('l j M')}} · {{$event->start_time->format('H:i')}} -
                            {{$event->end_time->format('H:i')}}</div>
                    @endif
                </div>
                <h3 class="text-sm">Descrizione</h3>
                <p class="pl-4 text-gray-500">{{$event->description}}</p>
            </div>
        </div>
        <div class="inline-flex gap-4">
            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border h-10 px-1 md:px-4 py-2 text-xs md:text-base" onclick="window.history.back();">
                Torna Indietro
            </button>
            <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-10 px-1 md:px-4 py-2 text-xs md:text-base" href="{{route('events.edit',$event)}}">Modifica</a>
            <form action="{{ route('events.destroy', $event) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200 h-10 px-1 md:px-4 py-2 text-xs md:text-base">Delete</button>
            </form>

        </div>

    </div>
@endsection
