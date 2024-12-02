<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lorem', function (Blueprint $table) {
            $table->id();

            $table->string('Bo Hampton')->notNullable();
            $table->json('Brenna Patrick')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lorem');
    }
};