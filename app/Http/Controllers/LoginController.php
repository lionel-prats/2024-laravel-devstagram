<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",  
            "password" => "required", 
        ]);
        if(!auth()->attempt($request->only("email", "password"), $request->remember)){
            return back()->with("mensaje", "Credenciales Incorrectas");
        }

        // hubo que implementar una modificacion en este redirect para que no haya fallas (ver explicacion en la notas del video 92)
        return redirect()->route("posts.index", auth()->user()->username);
    }
}
