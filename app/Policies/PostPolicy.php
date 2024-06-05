<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // $user es instancia del modelo User con la info el usuario autenticado (v129)
        // $post es instancia de un post a eliminar (v129)
        // este metodo delete() del Policy lo ejecutamos desde PostController->destroy() pasandole como argumento la instancia del post a eliminar (v129)
        return $user->id === $post->user_id;
    }
}

// // Esrtuctura default del Policy comentada, queda a modo de referencia (video 129)
// class PostPolicy
// {
//     /**
//      * Determine whether the user can view any models.
//      */
//     public function viewAny(User $user): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can view the model.
//      */
//     public function view(User $user, Post $post): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can create models.
//      */
//     public function create(User $user): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can update the model.
//      */
//     public function update(User $user, Post $post): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can delete the model.
//      */
//     public function delete(User $user, Post $post): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can restore the model.
//      */
//     public function restore(User $user, Post $post): bool
//     {
//         //
//     }

//     /**
//      * Determine whether the user can permanently delete the model.
//      */
//     public function forceDelete(User $user, Post $post): bool
//     {
//         //
//     }
// }
