<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Et non quidem quibus', function (Blueprint $table) {
            $table->id();
            $table->string('Faith Everett')->notNullable();
            $table->json('Macey Pace')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Et non quidem quibus');
    }
};