<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teni>
 */
class TeniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'model' => $this->faker->word, // Modelo del tenis
                'marca' => $this->faker->company, // Marca del tenis
                'color' => $this->faker->safeColorName, // Color principal
                'precio' => $this->faker->randomFloat(2, 50, 500), // Precio
                'talla' => $this->faker->numberBetween(35, 45), // Talla del tenis
                'material' => $this->faker->word, // Material principal
                'categoria' => $this->faker->randomElement(['Deportivo', 'Casual', 'Formal', 'Outdoor']), // Categoría
                'image' => 'img/example.png' // Imagen (puedes cambiarlo por una URL o ruta real si lo prefieres)
        ];
    }
}
