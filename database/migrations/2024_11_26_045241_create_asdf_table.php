<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asdf', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('asfd')->nullable();
            $table->enum('gdsdg', ['sdfa', 'asdfa'])->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asdf');
    }
};