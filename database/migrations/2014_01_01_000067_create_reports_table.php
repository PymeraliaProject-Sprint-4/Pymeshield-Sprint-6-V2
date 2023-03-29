<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(false);
            $table->enum('status', ['done', 'pending'])->nullable()->default(null);
            $table->foreignId('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->date('date')->nullable(false);
            $table->date('hidden')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
