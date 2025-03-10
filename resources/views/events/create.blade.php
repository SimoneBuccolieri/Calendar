@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold">Crea un nuovo evento</h1>
        <form action="{{ route('events.store') }}" method="POST" class="border shadow border-gray-200 bg-white rounded-xl p-4 my-4">
            @csrf
            <div class="flex flex-col md:flex-row  ">
                <p class="px-4 text-xl font-semibold">Titolo</p>
                <input type="text" name="title" class="border rounded border-gray-200 mb-3">
            </div>
            <div class="flex flex-col md:flex-row  ">
                <p class="px-4 text-xl font-semibold">Descrizione</p>
                <textarea name="description" class="border rounded border-gray-200 mb-3"></textarea>
            </div>
            <div class="flex flex-col md:flex-row  ">
                <p class="px-4 text-xl font-semibold">Inizio</p>
                <input type="datetime-local" name="start_time" class="border rounded border-gray-200 mb-3" value="{{now()->format('Y-m-d H:i')}}">
            </div>
            <div class="flex flex-col md:flex-row  ">
                <p class="px-4 text-xl font-semibold">Fine</p>
                <input type="datetime-local" name="end_time" class="border rounded border-gray-200 mb-3" value="{{now()->format('Y-m-d H:i')}}">
            </div>
            <div class="flex flex-col md:flex-row  ">
                <p class="px-4 text-xl font-semibold">Colore</p>
                <input type="color" name="color" value="#3498db" required>
            </div>
            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-blue-600 hover:text-white h-10  px-1 md:px-4 py-2 ">Salva</button>
        </form>
    </div>
@endsection
