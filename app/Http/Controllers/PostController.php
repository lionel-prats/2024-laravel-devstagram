<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // con esto restrinjo el acceso a cualquier ruta que maneje cualquiera de los metodos de este controlador a usuarios autenticados vvv
        $this->middleware("auth");
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
}
