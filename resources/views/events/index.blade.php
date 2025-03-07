@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold">Agenda</h1>
        <a href="{{ route('events.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Aggiungi Evento</a>

        <div class="mt-4">
            @foreach ($events as $event)
                <div class="p-4 border rounded bg-gray-100">
                    <h2 class="text-xl font-bold">{{ $event->title }}</h2>
                    <p class="text-sm">{{ $event->start_time->format('d/m/Y H:i') }} - {{ $event->end_time->format('H:i') }}</p>
                    <p>{{ $event->description }}</p>
                    <form action="{{ route('events.destroy', $event) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-4 py-1 rounded">Elimina</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
