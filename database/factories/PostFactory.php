<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = $this->faker->sentence(5);
        $descripcion = $this->faker->sentence(20);
        $imagen = $this->faker->uuid() . ".jpg";
        // $user_id = $this->faker->randomElement([1,2,3,4,5]);
        $user_id = User::all()->random()->id;
        return [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'imagen' => $imagen,
            'user_id' => $user_id,
        ];
    }
}
