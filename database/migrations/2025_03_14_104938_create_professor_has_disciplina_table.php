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
        Schema::create('professor_has_disciplina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_professor');
            $table->unsignedBigInteger('id_disciplina');
            
            $table->foreign('id_professor')->references('id')->on('professores')->onDelete('cascade');
            $table->foreign('id_disciplina')->references('id')->on('disciplinas')->onDelete('cascade');
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
        Schema::dropIfExists('professor_has_disciplina');
    }
};
