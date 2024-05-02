<?php

namespace Tests\Unit;

use App\Http\Services\UsuarioService;
use App\Models\Usuario;
use Faker\Factory as Faker;
use PDOException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();


        // Inicialize o Faker
        $this->faker = Faker::create();
    }

    public function testCadastrarUsuario()
    {
        $service = new UsuarioService();
        $usuario = new Usuario([
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'documento' => $this->faker->unique()->numerify('###########'), // Supondo que o campo seja um CPF
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000), // Gera um saldo aleatório entre 0 e 1000
            'senha' => $this->faker->password(), // Gera uma senha criptografada aleatória
        ]);


        $this->assertTrue($service->store($usuario));


        //Usuario com dados faltantes
        $usuarioComErro = new Usuario([
            'nome' => $this->faker->name(),
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password(),
        ]);

        $this->expectException(PDOException::class);
        $service->store($usuarioComErro);
    }
}
