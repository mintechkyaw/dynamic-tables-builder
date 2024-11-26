<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('test_column', ['1', '2', '3'])->nullable();
            $table->string('test_nae')->nullable();
            $table->json('test_name')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_tables');
    }
};
