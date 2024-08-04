<?php

namespace Database\Factories;
use App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Inventory::class;

    public function definition()
    {
        return [
            'location' => $this->faker->address,
            'capacity' => $this->faker->numberBetween(100, 1000),
            'current_stock' => $this->faker->numberBetween(0, 1000),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
