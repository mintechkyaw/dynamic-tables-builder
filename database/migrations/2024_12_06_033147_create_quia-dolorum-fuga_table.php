<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quia-dolorum-fuga', function (Blueprint $table) {
            $table->id();
            $table->enum('deserunt', ['explicabo', 'quis', 'consequatur'])->notNullable();
            $table->enum('est', ['quia', 'labore', 'et'])->nullable();
            $table->date('eum')->nullable();
            $table->string('ex')->notNullable();
            $table->string('laudantium')->notNullable();
            $table->enum('nostrum', ['esse', 'distinctio', 'et'])->notNullable();
            $table->string('omnis')->nullable();
            $table->json('quos')->nullable();
            $table->string('reiciendis')->notNullable();
            $table->date('voluptas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quia-dolorum-fuga');
    }
};