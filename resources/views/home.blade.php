@extends("layouts.app")

@section("titulo", "Página Principal")

@section('contenido')
    <x-listar-post :posts="$posts" />
    {{-- <x-listar-post>
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando posts desde slot</h1>
    </x-listar-post> --}}
@endsection