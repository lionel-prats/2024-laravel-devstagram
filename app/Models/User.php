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
     ** Este metodo lo usamos para interactuar con la tabla followers desde instancias del modelo User (nos permite todas las operaciones CRUD en la tabla followers) 
     * ---
     ** **Ejemplo de uso para hacer un INSERT** 
     * ```$user->followers()->attach($follower_id);```
     * ```sql
     * -- equivalente en SQL vvv
     * INSERT INTO followers (user_id, follower_id) VALUES ($user->id, $follower_id);
     * ```
     * ---
     ** Ejemplo de uso para hacer un DELETE 
     * ```$user->followers()->detach($follower_id);```
     * ```sql
     * -- equivalente en SQL vvv
     * DELETE FROM followers WHERE user_id = $user->id AND follower_id = $follower_id;
     * ```
     * ---
     ** Ejemplo de uso para hacer un SELECT 
     * ```$user->followers()->count();```
     * ```sql
     * -- equivalente en SQL vvv
     * SELECT COUNT(*) FROM followers WHERE user_id = $user->id;
     * ```
     * --- 
     ** IMPORTANTE: 
     *
     *      el valor de ```$user->id``` se asigna automaticamente al campo ```user_id``` y no al campo ```follower_id``` porque asi lo especifique dentro de este mismo metodo (parametros 3° y 4° del ```belongsToMany()``` respectivamente).
     *
     *      Si invierto el orden de estos 2 parametros, ```$user->id``` se asignara al campo ```follower_id```
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, "followers", "user_id", "follower_id");
        // return $this->belongsToMany(User::class, "followers", "follower_id", "user_id");
    }

    /**
     ** Este metodo funciona igual que el metodo followers(), con la unica diferencia de que el ```$user->id``` de la instancia desde la que ejecutamos este metodo se asigna automaticamente al campo follower_id
     * ---
     ** Ejemplo de uso para hacer un SELECT 
     * ```$user->followings()->count();```
     * ```sql
     * -- equivalente en SQL vvv
     * SELECT COUNT(*) FROM followers WHERE follower_id = $user->id;
     * ```
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, "followers", "follower_id", "user_id");
    }

    /**
     ** Este metodo nos permite saber si un usuario es seguido o no por otro
     * ---
     ** Ejemplo de uso
     * ```$user->es_seguido_por($follower_id);```
     * ```sql
     * -- equivalente en SQL vvv
     * SELECT IF(COUNT(*) >= 1, "true", "false") AS es_seguido
     * FROM followers 
     * WHERE user_id = $user->id 
     * AND follower_id = $follower_id
     * ```
     * --- 
     * return ```@bool true``` si el ```$user->id``` es seguido por  ```$follower_id```, ```@bool false``` en caso contrario.
     */
    // public function es_seguido_por(User $user)
    public function es_seguido_por($follower_id)
    {
        // return $this->followers->contains($user->id);
        return $this->followers->contains($follower_id);
    }
}