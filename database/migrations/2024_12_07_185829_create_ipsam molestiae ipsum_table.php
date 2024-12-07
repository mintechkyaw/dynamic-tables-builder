<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ipsam molestiae ipsum', function (Blueprint $table) {
            $table->id();
            $table->json('aliquam')->nullable();
            $table->json('quod')->notNullable();
            $table->string('voluptas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipsam molestiae ipsum');
    }
};