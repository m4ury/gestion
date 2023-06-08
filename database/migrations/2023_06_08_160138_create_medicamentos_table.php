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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->string('presentacion', 100);
            $table->string('unidad', 100)->nullable();
            $table->double('stock_max', 15, 8)->nullable()->default(0);
            $table->double('stock_fisico', 15, 8)->nullable()->default(0);
            $table->double('solicitado', 15, 8)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
