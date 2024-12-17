<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('okpar', function (Blueprint $table) {
            $table->id();
            $table->string('name')->notNullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('okpar');
    }
};