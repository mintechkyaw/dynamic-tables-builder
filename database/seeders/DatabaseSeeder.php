<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Form::factory()
            ->has(\App\Models\FormField::factory()->count(10), 'fields') // Each form gets 10 fields
            ->count(5)
            ->create();
    }
}
