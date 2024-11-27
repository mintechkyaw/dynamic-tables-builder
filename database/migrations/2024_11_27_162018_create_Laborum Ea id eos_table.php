<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('Laborum Ea id eos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('Knox Owens', ['Aliquip voluptatem', 'Nisi voluptas non ut'])->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Laborum Ea id eos');
    }
};