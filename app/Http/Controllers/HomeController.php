<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function __invoke()
    {
        // $seguidos_por_el_usuario_autenticado = auth()->user()->followings->toArray();
        
        $array_ids_usuarios_seguidos_por_el_usuario_autenticado = auth()->user()->followings->pluck("id")->toArray();

        $posts = Post::whereIn(
            "user_id", 
            $array_ids_usuarios_seguidos_por_el_usuario_autenticado)
            ->latest()
            ->paginate(3);
        $data = [
            "posts" => $posts
        ];
        return view('home', $data);
    }
}