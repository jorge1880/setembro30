<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('forum_id');
            $table->string('tipo'); // novo_forum, nova_resposta, mencao
            $table->boolean('lida')->default(false);
            $table->string('mensagem');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('notificacoes');
    }
}; 