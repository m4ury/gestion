<?php

namespace Tests\Feature\Meditamentos;

use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class indexTest extends TestCase
{
    use refreshDatabase;

    /** @test */
    public function an_authenticated_user_can_list_medicines()
    {
        //$this->withoutExceptionHandling();
        Medicamento::factory()->count(5)->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('medicamentos.index'));
        // TODO: validar la respuesta json
        //dump($response);
        $response->assertSuccessful();

        $this->assertDatabaseCount('medicamentos', 5);

    }
}
