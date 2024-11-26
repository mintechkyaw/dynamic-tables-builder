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
        $typeMapping = [
            'string' => 'text',
            'integer' => 'number',
            'json' => 'check_box',
            'enum' => 'radio',
            'date' => 'calendar',
        ];

        $dataType = $this->faker->randomElement(array_keys($typeMapping));
        $type = $typeMapping[$dataType];

        $options = in_array($type, ['check_box', 'radio'])
            ? json_encode($this->faker->words(3))
            : null;

        return [
            'form_id' => \App\Models\Form::factory(),
            'column_name' => $this->faker->unique()->word(),
            'data_type' => $dataType,
            'type' => $type,
            'options' => $options,
            'required' => $this->faker->boolean(),
        ];
    }
}
