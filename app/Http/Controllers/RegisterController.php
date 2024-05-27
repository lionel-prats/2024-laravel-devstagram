<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // modificamos parte del Request antes de la validacion para que ésta no falle v75()
        // ver explicacion en 0-notas-curso-valdez.txt
        $request->request->add(["username" => Str::slug($request->username)]);

        // validacion de formulario desde el backend
        $this->validate($request, [
            // esta sintaxis y las de abajo son igualmente validas
            "name" => ["required", "max:30"], 
            "username" => "required|min:3|max:30|unique:users",  
            "email" => "required|email|max:60|unique:users",  
            "password" => "required|min:6|confirmed", 
        ]);

        User::create([
            "name" => $request->get("name"),
            "email" => $request->email,
            "password" => $request->get("password"),
            // "password" => Hash::make($request->get("password")), (al menos desde la version 10.10 de laravel el hash es automatico)
            "username" => $request->username,
        ]);        
        auth()->attempt($request->only("email", "password"));
        return redirect()->route("posts.index");
    }
}
