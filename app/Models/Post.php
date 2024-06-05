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

    public function checkLike(User $user)
    {
        return $this->likes->contains("user_id", $user->id);
    }

}
