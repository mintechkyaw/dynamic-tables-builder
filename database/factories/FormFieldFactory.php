<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormField>
 */
class FormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'form_id' => \App\Models\Form::factory(),
            'column_name' => $this->faker->unique()->word(),
            'data_type' => $this->faker->randomElement(['string', 'integer', 'json', 'enum', 'date']),
            'type' => $this->faker->randomElement(['text', 'number', 'check_box', 'radio', 'calendar']),
            'options' => $this->faker->randomElement([
                json_encode(['option1', 'option2', 'option3']),
                json_encode(['yes', 'no']),
                json_encode([]),
            ]),
            'required' => $this->faker->boolean(),
        ];
    }
}
