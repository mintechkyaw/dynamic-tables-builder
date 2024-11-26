<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('test_name')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test');
    }
};