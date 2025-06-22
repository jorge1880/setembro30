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
        Schema::create('aula_has_cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aula');
            $table->unsignedBigInteger('id_curso');
            
            $table->foreign('id_aula')->references('id')->on('aulas')->onDelete('cascade');
            $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('cascade');
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
        Schema::dropIfExists('aula_has_cursos');
    }
};
