<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
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
     * este metodo procesa el submit del form para seguir un usuario (click en "btn.SEGUIR") desde el muro de un usuario
     * 
     * realiza un INSERT en followers, siendo F.user_id el id del usuario seguido (dueno del muro) y F.follower_id el id del usuario seguidor (usuario autenticado)
     * 
     * $user -> instancia del usuario dueno del muro
     * 
     * ruta -> POST http://devstagram.test/{user:username}/follow
     */
    public function store(User $user)
    {
        $user->followers()->attach(auth()->user()->id);
        return back();
    }

    /**
     * este metodo procesa el submit del form para dejar de seguir un usuario (click en "btn.DEJAR DE SEGUIR") desde el muro de un usuario
     * 
     * realiza un DELETE en followers, siendo F.user_id el id del usuario seguido (dueno del muro) y F.follower_id el id del usuario seguidor (usuario autenticado)
     * 
     * $user -> instancia del usuario dueno del muro
     * 
     * ruta -> DELETE http://devstagram.test/{user:username}/unfollow
     */
    public function destroy(User $user) 
    {
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}
