<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // con esto restrinjo el acceso a cualquier ruta que maneje cualquiera de los metodos de este controlador a usuarios autenticados vvv
        $this->middleware("auth");
    }

    private function ddl($data, $exit = null) 
    {
        if($exit == "v") {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
            return;
        } elseif($exit == "ve") {
            echo "<pre>";
            var_dump($data);
            exit;
        } elseif($exit == "pe") {
            echo "<pre>";
            print_r($data);
            exit;
        }
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function index(User $user)
    {
        $data = [
            "user" => $user,
        ];
        return view("dashboard", $data);
    }
    public function create()
    {
        return view("posts.create");
    }
    public function store(Request $request)
    {   
        $this->validate($request, [
            "titulo" => "required|max:255",  
            "descripcion" => "required",  
            "imagen" => "required",  
        ]); 

        $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();
        
        return redirect()->route("posts.index", auth()->user()->username);
    }
}
