<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferenciaTest extends TestCase
{
    use refreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->faker = Faker::create();
    }

    public function testTransferirComSucesso()
    {

        $usuarioTransferidor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor->save();
        $usuarioTransferidor->save();
        $arrayJson = [
            'id_transferidor' => $usuarioTransferidor->id,
            'id_receptor' =>  $usuarioReceptor->id,
            'valor_transferencia' => 50
        ];
        $response = $this->postJson('/api/transferir', $arrayJson);
        $response->assertStatus(200);

        /**
         * Buscando os dados atualizados dos usuarios
         */
        $usuarioReceptor = Usuario::find(1);
        $usuarioTransferidor = Usuario::find(2);

        $this->assertEquals(150, $usuarioTransferidor->saldo);
        $this->assertEquals(250, $usuarioReceptor->saldo);
    }

    public function testTransferirErroLojista()
    {
        $usuarioTransferidor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_LOJISTA,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_LOJISTA,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);
        $usuarioReceptor->save();
        $usuarioTransferidor->save();

        $arrayJson = [
            'id_transferidor' => $usuarioTransferidor->id,
            'id_receptor' =>  $usuarioReceptor->id,
            'valor_transferencia' => 50
        ];

        $response = $this->postJson('/api/transferir', $arrayJson);
        $response->assertStatus(400);
        $response->assertJson([
            "resposta" => "Apenas usuários comuns podem realizar transferências"            ]);
    }

    public function testTransferirSaldoInsuficiente()
    {
        $usuarioTransferidor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);
        $usuarioReceptor->save();
        $usuarioTransferidor->save();

        $arrayJson = [
            'id_transferidor' => $usuarioTransferidor->id,
            'id_receptor' =>  $usuarioReceptor->id,
            'valor_transferencia' => 300
        ];

        $response = $this->postJson('/api/transferir', $arrayJson);
        $response->assertStatus(400);
        $response->assertJson([
            "resposta" => "Saldo insuficiente para transferência"
            ]);
    }

    public function testTransferirValorInvalido()
    {
        $usuarioTransferidor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 200,
            'senha' => $this->faker->password,
        ]);
        $usuarioReceptor->save();
        $usuarioTransferidor->save();

        $arrayJson = [
            'id_transferidor' => $usuarioTransferidor->id,
            'id_receptor' =>  $usuarioReceptor->id,
            'valor_transferencia' => -300
        ];

        $response = $this->postJson('/api/transferir', $arrayJson);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['valor_transferencia']);
    }
}
