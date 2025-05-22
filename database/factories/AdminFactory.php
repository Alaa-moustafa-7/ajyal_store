<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            // 'username' => $this->faker()->unique()->userName,
            // 'password' => Hash::make('password'),
            // 'phone_number' => $this->faker->phoneNumber,
            // 'super_admin' => $this->faker->boolean,
            'name' => fake()->name(), 
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'password' => bcrypt('password'), // يمكنك تغييره حسب الحاجة
            'phone_number' => fake()->phoneNumber(),
            'super_admin' => fake()->boolean(),
        ];
    }
}
