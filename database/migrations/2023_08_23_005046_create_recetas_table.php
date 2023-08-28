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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->integer('folio')->unsigned()->nullable();
            $table->date('fecha_receta')->nullable();
            $table->enum('procedencia', ['Policlinico', 'Hospitalizados', 'Postrados', 'Hosp. Domiciliaria'])->nullable();
            $table->string('diagnostico', 100)->nullable();
            $table->foreignId('user_id')
            ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->nullable();
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
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
        Schema::dropIfExists('recetas');
    }
};
