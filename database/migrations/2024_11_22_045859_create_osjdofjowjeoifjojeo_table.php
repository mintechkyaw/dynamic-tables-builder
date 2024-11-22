<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('osjdofjowjeoifjojeo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('khine1', ['yes', 'no'])->notNullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('osjdofjowjeoifjojeo');
    }
};
