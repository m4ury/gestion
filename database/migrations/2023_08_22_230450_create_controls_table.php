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
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_control');
            $table->date('fecha_control');

            $table->float('sistolica', 8, 2)->nullable();
            $table->float('diastolica', 8, 2)->nullable();

            $table->float('hba1c', 8, 2)->nullable();

            $table->boolean('ldlMenor100')->nullable()->default(false);

            $table->text('observacion')->nullable();

            $table->date('proximo_control')->nullable();
            $table->string('tipo_atencion', 100)->nullable()->default('Presencial');

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->nullable();
            $table->foreignId('user_id')
                ->constrained('pacientes')
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->nullable();

            $table->unsignedFloat('peso_actual')->nullable();
            $table->unsignedFloat('talla_actual')->nullable();
            $table->unsignedFloat('imc')->nullable();
            $table->string('imc_resultado')->nullable();

            $table->enum('evaluacionPie', ['Alto', 'Moderado', 'Bajo', 'Maximo'])->nullable();
            $table->enum('ulcerasActivas_TipoCuracion', ['Avanzada', 'Convencional'])->nullable();

            $table->enum('asmaClasif', ['Leve', 'Moderado', 'Severo'])->nullable();
            $table->enum('asmaControl', ['Controlado', 'No Controlado', 'No Evaluado', 'Parcialmente Controlado'])->nullable();
            $table->enum('epocClasif', ['A', 'B'])->nullable();
            $table->enum('epocControl', ['Logra Control', 'No Logra Control', 'No Evaluado'])->nullable();
            $table->date('espirometriaVigente')->nullable();
            $table->enum('sborClasif', ['Leve','Moderado','Severo'])->nullable();

            $table->enum('trHumor', ['depLeve', 'depMod', 'depGrave', 'depPostParto', 'trBipolar'])->nullable();
            $table->enum('trConsumo', ['alcohol', 'drogas', 'policonsumo'])->nullable();
            $table->enum('trInfAdol', ['trHiper', 'trDis', 'trAnsInf', 'otrosTrsInfAdol'])->nullable();
            $table->enum('trAns', ['trEstresPostT', 'trPanicoAgo', 'trPanico', 'fobiaSocial', 'trAnsGen', 'otrosTrAns'])->nullable();
            $table->enum('demencias', ['leve', 'moderado', 'avanzado'])->nullable();
            $table->enum('diagSm', ['esquizo', 'epEsquizo', 'trCondAlim', 'retrasoMental', 'trPersonalidad', 'epilepsia', 'otras'])->nullable();
            $table->enum('trDesarrollo', ['autismo', 'asperger', 'rett', 'trDesinteg', 'trNOespecif'])->nullable();

            $table->enum('rEfam', ['autovalente', 'rDependencia', 'autConRiesgo', 'autSinRiesgo', 'dLeve', 'dMod', 'dSevero', 'dTotal', 'Independiente'])->nullable();
            $table->enum('rCaidas', ['r_leve', 'r_normal', 'r_alto'])->nullable();
            $table->enum('uPodal', ['u_normal', 'u_alterado'])->nullable();
            $table->boolean('seguimiento')->nullable()->default(false);

            $table->enum('rCero', ['bajo', 'alto'])->nullable();
            $table->enum('dCaries', ['none', '1_2', '3_4', '5_6', '7_8', 'mas_9'])->nullable();

            $table->boolean('inasistente')->nullable()->default(false);

            $table->enum('hormonal', ['oral_comb', 'oral_progest', 'inyectable_comb', 'inyectable_progest', 'implante_etonogest', 'anillo'])->nullable();
            $table->enum('preservativo', ['Hombres', 'Mujer'])->nullable();
            $table->boolean('diu_cobre')->nullable()->default(false);
            $table->boolean('diu_levonorgest')->nullable()->default(false);
            $table->boolean('esterilizacion')->nullable()->default(false);
            $table->boolean('condon_fem')->nullable()->default(false);
            $table->date('empVigente')->nullable();
            $table->date('papVigente')->nullable();
            $table->boolean('climater')->nullable()->default(false);

            $table->boolean('ginec')->nullable()->default(false);
            $table->boolean('regulacion')->nullable()->default(false);
            $table->date('mamoVigente')->nullable();
            $table->enum('trh', ['Estradiol Micronizado 1mg', 'Estradiol Gel', 'Tibolona 2,5mg comp.'])->nullable();
            $table->integer('pauta_mrs')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
