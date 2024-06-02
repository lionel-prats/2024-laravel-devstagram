<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {   
        // valido el form de crear comentarios
        $this->validate($request, [
            "comentario" => "required|max:255",
        ]); 

        // almaceno el comentario en comentarios
        Comentario::create([
            "user_id" => auth()->user()->id,  
            "post_id" => $post->id,  
            "comentario" => $request->comentario,  
        ]);

        // redirijo al usuario a la ruta desde la cual hizo la peticion con un mensaje en la variable de sesion "mensaje"
        return back()->with("mensaje", "Comentario Realizado Correctamente");
    }
}
