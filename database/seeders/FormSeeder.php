<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Form::factory()
            ->has(\App\Models\FormField::factory()->count(10), 'fields')
            ->count(5)
            ->create();
    }
}
