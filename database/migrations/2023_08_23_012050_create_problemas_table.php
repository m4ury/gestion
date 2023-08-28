<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('problemas', function (Blueprint $table) {
            $table->id();
            $table->string('problema_descripcion', 100)->nullable();
            $table->integer('num_ges')->unsigned()->unique()->nullable;
            $table->foreignId('ayuda_id')
            ->constrained('ayudas')
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problemas');
    }
};
