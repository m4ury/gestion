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
        Schema::create('medicamento_pedido', function (Blueprint $table) {
            $table->foreignId('medicamento_id')
                ->constrained('medicamentos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
