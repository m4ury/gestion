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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('sol_rut');
            $table->unsignedInteger('sol_ficha')->nullable();
            $table->date('sol_fecha');
            $table->enum('sol_estado', ['solicitado', 'medicina', 'some', 'a_social', 'otros', 'box_medico', 'acreditacion'])->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->nullable();
            $table->timestamps();

            $table->string('sol_comentario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
