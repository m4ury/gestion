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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique();
            $table->index('rut');
            $table->enum('sexo', ['Masculino', 'Femenino', 'Otros']);
            $table->string('nombres');
            $table->string('apellidoP');
            $table->string('apellidoM')->nullable();
            $table->unsignedInteger('ficha')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('direccion');
            $table->enum('comuna', ['Cauquenes', 'Chanco', 'Pelluhue', 'Curico', 'Hualane', 'Licanten', 'Molina', 'Rauco', 'Romeral', 'Sgda Familia', 'Teno', 'Vichuquen', 'Linares', 'Colbun', 'Longabi', 'Parral', 'Retiro', 'San Javier', 'Villa Alegre', 'Yerbas Buenas', 'Talca', 'Constitucion', 'Empedrado', 'Maule', 'Pelarco', 'Pencahue', 'Rio Claro', 'San Clemente', 'San Rafael', 'Curepto'])->nullable();
            $table->string('telefono')->nullable();
            $table->enum('sector', ['Naranjo', 'Celeste', 'Blanco']);
            $table->boolean('migrante')->nullable()->default(false);
            $table->boolean('pueblo_originario')->nullable()->default(false);
            $table->enum('riesgo_cv', ['Bajo', 'Moderado', 'Alto'])->nullable();
            $table->enum('erc', ['sin', 'I', 'II', 'IIA', 'III', 'IIIA', 'IIIB', 'IIIB-IV', 'IV', 'V'])->nullable();
            $table->boolean('compensado')->nullable()->default(false);

            $table->boolean('discap')->nullable()->default(false);
            $table->boolean('embarazada')->nullable()->default(false);
            $table->boolean('sename')->nullable()->default(false);
            $table->boolean('mejor_ninez')->nullable()->default(false);

            $table->enum('egreso',['fallecido', 'inasistente', 'cambio_centro'])->default('inasistente')->nullable();
            $table->date('fecha_egreso')->nullable();

            $table->boolean('ingreso')->nullable()->default(false);
            $table->date('fecha_ingreso')->nullable();

            $table->boolean('usoInsulina')->nullable()->default(false);
            $table->boolean('usoIecaAraII')->nullable()->default(false);
            $table->boolean('usoAspirinas')->nullable()->default(false);
            $table->boolean('usoEstatinas')->nullable()->default(false);
            $table->date('aputacionPieDM2')->nullable();
            $table->boolean('maltrato')->nullable()->nullable()->default(false);
            $table->boolean('actFisica')->nullable()->nullable()->default(false);

            $table->date('racVigente')->nullable();
            $table->date('vfgVigente')->nullable();
            $table->date('fondoOjoVigente')->nullable();
            $table->date('ecgVigente')->nullable();
            $table->date('controlPodologico_alDia')->nullable();
            $table->date('espirometriaVigente')->nullable();
            $table->date('ldlVigente')->nullable();

            $table->enum('postrado_oncol', ['oncologico', 'no oncologico'])->nullable();
            $table->boolean('escaras')->nullable()->default(0);

            $table->enum('otras_enf', ['Otras respiratorias cronicas', 'Oxigeno dependiente', 'Asistencia ventilatoria no invasiva o invasiva', 'Fibrosis quistica'])->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
