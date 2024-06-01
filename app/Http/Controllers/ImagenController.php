<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

// use Intervention\Image\Laravel\Facades\Image;

use Intervention\Image\ImageManager;      // implementacion de InterventionImage (v98)
use Intervention\Image\Drivers\Gd\Driver; // tuve que incorporar el Driver GD en lugar de Imagick para que InterventionImage funcione (v98)

class ImagenController extends Controller
{
    public function store(Request $request) // (metodo creado y configurado entre los videos 94 y 98)
    {
        // $input = $request->all();
        $imagen = $request->file('file'); // guardo la imagen cargada desde el form #dropzone desde el cliente (esta imagen se mantiene un tiempo en memoria en el server)
        $nombreImagen = Str::uuid() . "." . $imagen->extension(); // con el helper Str genero un nombre unico para la imagen antes de guardarla en el server
        $manager = new ImageManager(new Driver()); // instancio InterventionImage
        $imagenServidor = $manager::gd()->read($imagen); // habilito el procesamiento con InterventionImage de la imagen cargada en memoria
        $imagenServidor->resizeDown($width=1000, $height=1000); // redefino el width y el height de la imagen antes de guardarla en el server
        $imagenPath = public_path("uploads") . "/" . $nombreImagen; // defino el path completo con el que se guardara la imagen en el server (/public/uploads/123456789.jpg)
        $imagenServidor->save($imagenPath); // guardo la imagen procesada con InterventionImage en el server
        return response()->json([
            'imagen' => $nombreImagen,
        ]);
    }
}