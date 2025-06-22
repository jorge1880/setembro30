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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('morada', 100);
            $table->date('nascimento');
            $table->integer('processo_n');
            $table->string('nome_mae', 100);
            $table->string('nome_pai', 100);
            $table->string('telefone');
            $table->string('naturalidade', 45);
            $table->string('area_formacao', 45);
           

            $table->unsignedBigInteger('id_ano')->nullable();
            $table->unsignedBigInteger('id_turma')->nullable();
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->unsignedBigInteger('id_curso')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();

            $table->foreign('id_ano')->references('id')->on('ano_lectivos');
            $table->foreign('id_turma')->references('id')->on('turmas');
            $table->foreign('id_classe')->references('id')->on('classes');
            $table->foreign('id_curso')->references('id')->on('cursos');
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('matriculas');
    }
};
