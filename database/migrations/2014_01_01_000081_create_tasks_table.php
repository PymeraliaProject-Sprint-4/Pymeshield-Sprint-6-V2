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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('state',['ToDo','InProgress','Done'])->nullable()->default('ToDo');
            $table->datetime('start_date')->nullable();
            $table->datetime('final_date')->nullable();
            $table->float('price')->nullable()->default(0);
            $table->float('price_customer')->nullable()->default(0);
            $table->enum('manages', ['Me aconseja Pymeralia', 'Me lo gestiono yo', 'No aceptada'])->nullable()->default('No aceptada');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('questionnaire_id')->constrained();
            $table->foreignId('answer_id')->constrained();
            $table->foreignId('budget_id')->constrained();
            $table->foreignId('impact_id')->constrained();
            $table->BigInteger('percentage')->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
