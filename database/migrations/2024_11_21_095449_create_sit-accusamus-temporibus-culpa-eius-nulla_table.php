<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sit-accusamus-temporibus-culpa-eius-nulla', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('alias')->nullable();
            $table->string('at')->nullable();
            $table->integer('cum')->nullable();
            $table->string('dignissimos')->nullable();
            $table->date('ea')->nullable();
            $table->string('illum')->nullable();
            $table->string('natus')->nullable();
            $table->date('odit')->nullable();
            $table->string('ut')->nullable();
            $table->string('voluptas')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sit-accusamus-temporibus-culpa-eius-nulla');
    }
};