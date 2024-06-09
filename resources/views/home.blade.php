@extends("layouts.app")

@section("titulo", "Página Principal")

@section('contenido')
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post) {{-- v157 --}}
                <div>
                    <a href="{{route("posts.show", ["user" => $post->user, "post" => $post])}}">
                        <img src="{{ asset("uploads/$post->imagen") }}" alt="Imagen del post {{$post->titulo}}">
                    </a>
                    <p class="text-normal text-gray-500 font-bold">{{$post->user->username}}</p>
                    <p class="text-sm text-gray-500">{{$post->created_at->format('l, M d, Y');}}</p>
                </div>
            @endforeach
        </div>
        <div class="my-10">
            {{$posts->links("pagination::tailwind")}}
        </div>   
    @else
        <p class="text-center">No hay Posts</p>
    @endif
@endsection