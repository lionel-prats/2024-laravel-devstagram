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
    
     /**
     * array con los nombres de las 20 imagenes almacenadas en /public/uploads
     */
    private $images = [
        "845177a5-5f69-4bb5-972a-fe447737c91d.jpg",
        "a7e58f61-d0e0-42e8-a333-d6059f9b65d0.jpg",
        "a3eb832a-fdac-4727-80da-e00337022e4b.jpg",
        "9850337b-4967-4d76-8051-e8bc0e552613.jpg",
        "f6487d50-1c7d-4514-b91c-bae0518767b9.jpg",
        "1eaf0483-82b7-41bb-a81c-f0b2c2132733.jpg",
        "751e609c-e2fd-4fca-81c7-878e98ab49c8.jpg",
        "b93d1adb-5ffb-4127-bdfd-8a98fa95e668.jpg",
        "e3324237-f544-47cd-80f3-9ec4b8f0eac6.jpg",
        "c91a15ad-41cb-4f01-b818-4465409e094a.jpg",
        "44d6095f-d8f4-48fb-93d8-bf445f90031e.jpg",
        "8f631426-391d-4898-9b39-3a6985090804.jpg",
        "c3acda37-9acd-4a24-ba4d-b7b348c15e04.jpg",
        "738f1dae-4c06-4dbb-8b89-60bd625cb3d4.jpg",
        "82ad514c-605b-4ff8-ac3e-32b70803497c.jpg",
        "5b526b52-c52d-4e5b-a8d2-490e0ec61dd0.jpg",
        "db2e3a6a-8b53-4f14-aa36-f1ef221756f4.jpg",
        "9eec8af7-ac74-427d-8c08-133c6e7177f5.jpg",
        "e84f5efe-bb78-4064-b449-42b731b8bed4.jpg",
        "5764c6ab-c306-496e-ad77-7ac703a354d6.jpg"
    ];

    public function definition(): array
    {
        $titulo = $this->faker->sentence(5);

        $descripcion = $this->faker->sentence(20);
        
        // $imagen = $this->faker->uuid() . ".jpg";
        $imagen = $this->faker->randomElement($this->images);
        
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
