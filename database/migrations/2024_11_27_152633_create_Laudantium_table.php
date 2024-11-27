<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Laudantium', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('Avye Miller', ['option1', 'option2'])->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Laudantium');
    }
};