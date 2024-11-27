<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Animi labore enim a', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('Stacy Maynard', ['Fuga Tempore ut au'])->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Animi labore enim a');
    }
};