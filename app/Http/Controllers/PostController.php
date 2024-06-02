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
        // $this->middleware("auth");

        $this->middleware("auth")->except(["index","show"]);
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
        // // acceder a los posts asociados a un usuario usando la coleccion posts() definida en el modelo User (v117) vvv
        // foreach($user->posts as $i=>$post){
        //     $this->ddl($i . " = " . $post->titulo);
        // }

        // $posts = Post::where("user_id", $user->id)->get();
        // $posts = Post::where("user_id", $user->id)->simplePaginate(4);
        $posts = Post::where("user_id", $user->id)->paginate(8);

        $data = [
            "user" => $user,
            "posts" => $posts,
        ];
        return view("dashboard", $data);
    }
    public function create()
    {
        return view("posts.create");
    }
    public function store(Request $request)
    {   
        // $this->ddl(auth()->user(), "pe");   // App\Models\User Object
        // $this->ddl($request->user(), "pe"); // App\Models\User Object
        $this->validate($request, [
            "titulo" => "required|max:255",  
            "descripcion" => "required",  
            "imagen" => "required",  
        ]); 
        
        // esta es una de al menos 4 formas de hacer un INSERT en la DB 
        // ver detalles en notas, video 107 
        $request->user()->posts()->create([
            "titulo" => $request->titulo,
            "descripcion" => $request->descripcion,
            "imagen" => $request->imagen,
            // "user_id" => auth()->user()->id,
        ]);
        return redirect()->route("posts.index", auth()->user()->username);
    }
    public function show(User $user, Post $post)
    {
        $data = [
            "user" => $user, // objeto User del usuario del muro que estamos visitando
            "post" => $post,
        ];
        return view("posts.show", $data);
    }
}
