<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('patrimonio')->unique();
            $table->unsignedInteger('quantidade')->default(1);
            $table->unsignedInteger('quantidade_disponivel')->default(1);
            $table->enum('status',['disponivel','emprestado'])->default('disponivel');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
