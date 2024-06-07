<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // relacion entre users y likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * este metodo lo usamos para hacer un INSERT o un DELETE en followers
     * 
     * se debe ejecutar desde una instancia de User, adjudicandose automaticamente el id de esa instancia al campo F.user_id, y el id recibido por parametro al campo F.follower_id
     * 
     * Ejemplo de uso INSERT => $user->followers()->attach(3); 
     * 
     * en este ejemplo, el INSERT es el siguiente => F.user_id = $user->id | F.follower_id = 3
     * 
     * Ejemplo de uso DELETE => $user->followers()->detach(3); 
     * 
     * en este ejemplo, el DELETE es el siguiente => WHERE F.user_id = $user->id AND F.follower_id = 3
     * 
     * IMPORTANTE => F.user_id toma el valor $user->id porque en este metodo lo definimos antes que F.follower_id
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, "followers", "user_id", "follower_id");
    }

    /**
     * este metodo nos permite saber si un usuario ya sigue a otro
     * 
     * se debe ejecutar desde una instancia de User
     * 
     * Ejemplo de uso => $user->es_seguido_por(3); 
     * 
     * consulta SQL => SELECT COUNT(*) AS total FROM followers WHERE user_id = $user->id and follower_id = 3
     * 
     * return bool => bool: TRUE si total > 0, FALSE en caso contrario
     */
    // public function es_seguido_por(User $user)
    public function es_seguido_por($follower_id)
    {
        // return $this->followers->contains($user->id);
        return $this->followers->contains($follower_id);
    }

    /**
     * almacenar los que seguimos
     */
}