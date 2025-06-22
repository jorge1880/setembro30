<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_id');
            $table->unsignedBigInteger('user_id');
            $table->text('texto');
            $table->string('anexo')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('silenciado')->default(false);
            $table->timestamps();
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}; 