<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100)->nullable();
            $table->integer('cantidad')->unsigned()->nullable()->default(0);
            $table->boolean('lateralidad')->nullable()->default(false);
            $table->boolean('maciza')->nullable()->default(false);
            $table->boolean('inflable')->nullable()->default(false);
            $table->boolean('basculante')->nullable()->default(false);
            $table->boolean('reclinable')->nullable()->default(false);
            $table->enum('talla', ['S', 'M', 'L', 28, 30, 33, 35, 36, 40, 42, 43, 45, 46, 48, 50, 53])->nullable();
            $table->enum('puntos', [1, 3, 4])->nullable();
            $table->foreignId('receta_id')
            ->constrained('recetas')
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
        Schema::dropIfExists('ayudas');
    }
};
