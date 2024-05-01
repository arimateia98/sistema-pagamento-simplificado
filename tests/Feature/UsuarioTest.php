<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Faker\Factory as Faker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioTest extends TestCase
{
    use refreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        // Inicialize o Faker
        $this->faker = Faker::create();
    }

    public function testStoreUsuario()
    {
        $usuario = [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ];

        $response = $this->postJson('/api/usuarios', $usuario);
        $response->assertStatus(200);
    }

    public function testStoreUsuarioErro()
    {
        $usuario = [
            'nome' => $this->faker->name,
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ];

        $response = $this->postJson('/api/usuarios', $usuario);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['email','documento']);
    }
}
