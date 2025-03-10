@extends('layouts.app')
@section('content')
    <div class="container mx-auto py-8 px-4">
        <h1>Modifica Evento</h1>
        <h2 class="uppercase font-bold">{{$event->title}}</h2>
        <div class=" border shadow border-gray-200 bg-white rounded-xl p-4 my-4">
            <form class="" action="{{route('events.update',$event)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-col md:flex-row  ">
                    <p class="px-4 ">Oggetto</p>
                    <input class="border rounded border-gray-200 mb-3  " type="text" name="title" value="{{$event->title}}">
                </div>
                <div class="flex flex-col md:flex-row ">
                    <p class="px-4">Descrizione</p>
                    <input class="border rounded border-gray-200  mb-3" type="text" name="description" value="{{$event->description}}">
                </div>
                <div class="flex flex-col md:flex-row  ">
                    <p class="px-4  ">Inizio</p>
                    <input class="border rounded border-gray-200  mb-3" type="datetime-local" name="start_time" value="{{$event->start_time}}">
                </div>
                <div class="flex flex-col md:flex-row  ">
                    <p class="px-4  ">Fine</p>
                    <input class="border rounded border-gray-200  mb-3" type="datetime-local" name="end_time" value="{{$event->end_time}}">
                </div>
                <div class="flex flex-col md:flex-row  ">
                    <p class="px-4 ">Colore</p>
                    <input class="border rounded border-gray-200  mb-3" type="color" name="color" value="{{$event->color}}" required>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-blue-600 hover:text-white h-10  px-1 md:px-4 py-2 ">
                    Salva
                </button>
            </form>


        </div>
        <button class="  inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-200 hover:bg-gray-200  h-10  px-1 md:px-4 py-2" onclick="window.history.back();">
            Torna Indietro
        </button>
    </div>
@endsection
