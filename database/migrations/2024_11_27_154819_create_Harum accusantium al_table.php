<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Harum accusantium al', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Yeo Wells')->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Harum accusantium al');
    }
};