<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id',
    ];
    public function user()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class)->select(["name", "username"]);
    }

    // relacion entre posts y comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // relacion entre posts y likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     ** Este metodo nos permite saber si un usuario le dio o no like a un post
     ** Lo que hace, es buscar en la tabla likes si existe algun registro con un post_id y un user_id determinado
     * ---
     ** Ejemplo de uso
     * ```$post->checkLike($user);```
     * ```sql
     * -- equivalente en SQL vvv
     * SELECT IF(COUNT(*) >= 1, "true", "false") AS dio_like
     * FROM likes 
     * WHERE post_id = $post->id
     * AND user_id = $user->id 
     * ```
     * --- 
     * return ```@bool true``` si existe uno o mas registros con post_id = ```$post->id``` y user_id = ```$user->id```, ```@bool false``` en caso contrario.
     */
    public function checkLike(User $user)
    {
        return $this->likes->contains("user_id", $user->id);
    }

}
