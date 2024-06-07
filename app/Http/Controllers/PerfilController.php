<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;      // implementacion de InterventionImage (v98)
use Intervention\Image\Drivers\Gd\Driver; // tuve que incorporar el Driver GD en lugar de Imagick para que InterventionImage funcione (v98)

use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    public function __construct()
    {
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

    /**
     * este metodo muestra el form de edicion de perfil de un usuario autenticado
     * 
     * $user -> instancia del usuario autenticado
     * 
     * ruta -> GET http://devstagram.test/editar-perfil
     */
    public function index(User $user)
    {
        $data = [
        ];
        return view("perfil.index", $data);
    }

    /**
     * este metodo procesa el form de edicion de perfil de un usuario autenticado
     * 
     * el usuario puede actualizar: email, username, imagen y password
     * 
     * $request -> datos cargados y enviados en el form desde el cliente
     * 
     * ruta -> POST http://devstagram.test/editar-perfil
     */
    public function store(Request $request)
    {   
        // $this->ddl($request->password, "ve");
        $validations = [
            "email" => [
                "required", 
                "email", 
                "max:60", 
                "unique:users,email," . auth()->user()->id,
            ],  
            "username" => [
                "required", 
                "min:3", 
                "max:30", 
                "unique:users,username," . auth()->user()->id, // con esto no rompe (ver v142) 
                "not_in:twitter,editar-perfil",
                // "in:CLIENTE,PROVEEDOR,VENDEDOR", // v142
            ],  
            "verified_password" => "required",
        ];
        if($request->filled('password')){
            $validations["password"] = [
                "required", 
                "min:6", 
                "confirmed", 
            ];
        }

        $request->request->add(["username" => Str::slug($request->username)]); // modifico el campo "username" del request

        $this->validate($request, $validations);
     
        // el usuario autenticado tiene que ingresar cprrectamente su password actual si quiere actualizar su perfil 
        // si ingresa un password incorrecto se cierra la sesion y se lo reddirige al login con un mensaje
        if(!Hash::check($request->verified_password, auth()->user()->password)) {
            // Auth::logout(); 
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'password' => 'Ingresaste un password incorrecto. Tu sesión se ha cerrado por seguridad.',
            ]);
        }

        $usuario = User::find(auth()->user()->id);

        // bloque para actualizar la foto de perfil de un usuario
        if($request->imagen) {
            
            // si el usuario ya tenia foto de perfil, la elimino del server
            if($usuario->imagen) {
                $imagen_path = public_path("perfiles/" . $usuario->imagen);
                if(File::exists($imagen_path)){
                    unlink($imagen_path);
                }
            }
            
            // $this->ddl($request->imagen, "v");
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension(); 
            $manager = new ImageManager(new Driver()); 
            $imagenServidor = $manager::gd()->read($imagen); 
            $imagenServidor->resizeDown($width=1000, $height=1000);
            $imagenPath = public_path("perfiles") . "/" . $nombreImagen; 
            $imagenServidor->save($imagenPath); 
        } 
        
        // Guardar Cambios
        $usuario->email = $request->email;
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        if($request->password){
            $usuario->password = $request->password;
        }
        $usuario->save();

        // redireccion
        return redirect()->route("posts.index", $usuario->username);
    }
}
