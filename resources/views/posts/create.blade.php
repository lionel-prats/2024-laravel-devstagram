@extends("layouts.app")

@section("titulo", "Crea una nueva publicación")

@push('styles')
    {{-- dropzone (v94) --}}
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <form 
                action="{{ route("imagenes.store") }}" 
                method="POST"
                enctype="multipart/form-data"
                id="dropzone"
                class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center"     
            >
                @csrf
            </form> 
        </div>
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST" id="user-register-form" novalidate>
                @csrf
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="titulo"
                    >Título</label>
                    <input 
                        class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror"
                        value="{{ old('titulo') }}"
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Título de la Publicación"
                    >
                    @error("titulo")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="descripcion"
                    >Descripción</label>
                    <textarea 
                        class="border p-3 w-full rounded-lg @error('descripcion') border-red-500 @enderror"
                        id="descripcion"
                        name="descripcion"
                        placeholder="Descripción de la Publicación"
                    >{{ old('descripcion') }}</textarea>
                    @error("descripcion")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <input 
                        type="text"
                        name="imagen"
                        value="{{ old('imagen') }}"    
                    >
                </div>
                @error("imagen")
                    <p 
                        class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                    >{{ $message }}</p>
                @enderror
                <input 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    type="submit" value="Crear Publicación"
                >
            </form>
        </div>
    </div>
@endsection