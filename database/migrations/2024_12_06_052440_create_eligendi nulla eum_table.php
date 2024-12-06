<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('eligendi nulla eum', function (Blueprint $table) {
            $table->id();
            $table->enum('accusantium', ['debitis', 'et', 'magni'])->notNullable();
            $table->enum('ad', ['quia', 'sed', 'magnam'])->nullable();
            $table->enum('modi', ['voluptatem', 'commodi', 'exercitationem'])->notNullable();
            $table->string('neque')->nullable();
            $table->string('nihil')->notNullable();
            $table->string('quod')->nullable();
            $table->date('sapiente')->notNullable();
            $table->string('tempore')->nullable();
            $table->json('vitae')->notNullable();
            $table->string('voluptate')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eligendi nulla eum');
    }
};