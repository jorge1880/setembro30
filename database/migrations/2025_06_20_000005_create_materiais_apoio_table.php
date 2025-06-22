<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('materiais_apoio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aula_id');
            $table->unsignedBigInteger('professor_id');
            $table->string('titulo');
            $table->string('arquivo')->nullable();
            $table->string('link')->nullable();
            $table->enum('tipo', ['arquivo', 'link']);
            $table->text('descricao')->nullable();
            $table->timestamps();
            $table->foreign('aula_id')->references('id')->on('aulas')->onDelete('cascade');
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('materiais_apoio');
    }
}; 