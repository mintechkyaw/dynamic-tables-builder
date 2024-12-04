<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form>
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug(2),
            'status' => $this->faker->randomElement(['drafted', 'published']),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function ($form) {
            $permissions = ['create', 'read', 'update', 'delete'];
            foreach ($permissions as $action) {
                Permission::create([
                    'name' => "{$form->slug}-{$action}",
                ]);
            }
        });
    }
}
