@extends("layouts.app")

@section("titulo", "Perfil: $user->username")
@section('contenido')
    @session('publicacion_eliminada')
        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
            {{session("publicacion_eliminada")}}
        </div>
    @endsession
    <div class="flex justify-center">
        <div class="w-full md:8/12 lg:6/12 flex flex-col items-center md:flex-row">
            <div class="w-2/12 lg:w-3/12"></div>
            <div class="w-4/12 lg:w-3/12 px-5">
                <img src="{{ $user->imagen ? asset("perfiles/$user->imagen") : asset("img/usuario.svg") }}" alt="imagen usuario">
            </div>
            <div class="w-4/12 lg:w-3/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a 
                                class="text-gray-500 hover:text-gray-600 cursor-pointer"
                                href="{{route("perfil.index")}}" 
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{ $user->followers()->count() }} 
                    {{-- <span class="font-normal">Seguidores</span> --}}
                    <span class="font-normal">@choice("Seguidor|Seguidores", $user->followers()->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followings()->count() }}  
                    <span class="font-normal">Siguiendo</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->posts->count()}} 
                    <span class="font-normal">Posts</span>
                </p>
                @auth
                    @if ($user->id !== auth()->user()->id)
                        {{-- @if ($user->es_seguido_por( auth()->user() )) --}}
                        @if ($user->es_seguido_por( auth()->user()->id ))
                            <form 
                                method="POST"
                                action="{{route("users.unfollow", $user)}}"
                            >
                                @method("DELETE")
                                @csrf
                                <input
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" 
                                    type="submit" 
                                    value="Dejar de Seguir"
                                >
                            </form>
                        @else
                            <form 
                                method="POST"
                                action="{{route("users.follow", $user)}}"
                            >
                                @csrf
                                <input
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" 
                                    type="submit" 
                                    value="Seguir"
                                >
                            </form>
                        @endif
                        
                    @endif
                @endauth
            </div>
            <div class="w-2/12 lg:w-3/12"></div>
        </div>
    </div>
    <section class="mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
        <x-listar-post :posts="$posts" />
    </section>
@endsection