<?php

namespace Tests\Unit;

use App\Http\Services\TransferenciaService;
use App\Models\Usuario;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferirServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();


        // Inicialize o Faker
        $this->faker = Faker::create();
    }

    public function testTransferir()
    {
        $service = new TransferenciaService();
        $usuarioTransferidor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 400,
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 0,
            'senha' => $this->faker->password,
        ]);
        $usuarioTransferidor->save();
        $usuarioReceptor->save();
        $this->assertEquals([
            "status" => true,
            "mensagem" => "A Transfêrencia foi realizada com sucesso"
        ], $service->transferir($usuarioTransferidor->id, $usuarioReceptor->id, 200));

        //Buscando os usuarios com os saldos atualizados
        $usuarioTransferidor = Usuario::find($usuarioTransferidor->id);
        $usuarioReceptor = Usuario::find($usuarioReceptor->id);
        $this->assertEquals(200, $usuarioTransferidor->saldo);
        $this->assertEquals(200, $usuarioReceptor->saldo);
    }
}
