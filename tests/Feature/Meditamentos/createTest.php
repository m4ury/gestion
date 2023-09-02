<?php

namespace Tests\Feature\Meditamentos;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class createTest extends TestCase
{
    use refreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_medicine()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('medicamentos.store'), [
           'descripcion' => 'Paracetamol',
            'presentacion' => 'Tabletas',
            'unidad' => 'mg',
            'stock_max' => '100',
            'stock_fisico' => '10',
            'solicitado' => '0',
        ]);

        $this->assertDatabaseCount('medicamentos', 1);
    }
}
