<?php

namespace Tests\Unit;

use App\Http\Services\NotificacaoService;
use App\Models\Usuario;
use Faker\Factory as Faker;
use Tests\TestCase;

class NotificacaoTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }


    public function testNotificacao()
    {

        $usuarioTransferidor = new Usuario([
            'nome' => 'José',
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ]);

        $usuarioReceptor = new Usuario([
            'nome' => 'João',
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ]);
        $this->assertEquals(
            'Você enviou uma transfêrencia para João de valor R$: 50',
            NotificacaoService::getMensagemEnvio($usuarioReceptor, 50)
        );
        $this->assertEquals(
            'Você recebeu uma transfêrencia de José de valor R$: 50',
            NotificacaoService::getMensagemRecebimento($usuarioTransferidor, 50)
        );

        $this->assertEquals([
            "message" => true
        ], NotificacaoService::enviaEmail($usuarioTransferidor->email, "teste"));
    }
}
