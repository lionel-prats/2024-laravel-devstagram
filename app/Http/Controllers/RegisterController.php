<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // validacion
        $this->validate($request, [
            // "name" => "required|min:5", 
            "name" => ["required", "max:30"],  
            "username" => "required|unique:users|min:3|max:20",  
            "email" => "required|unique:users|email|max:60",  
            "password" => "required", 
            // "password_confirmation" => "required|unique:users|min:5|max:20",   
        ]);
        dd("paso la validacion");
    }
}
