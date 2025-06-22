<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->unsignedBigInteger('user_id'); // professor criador
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->enum('status', ['novo', 'em_andamento', 'encerrado'])->default('novo');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('forums');
    }
}; 