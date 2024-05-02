<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Exception;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();


        // Inicialize o Faker
        $this->faker = Faker::create();
    }



    public function testDadosValidos()
    {
        $usuario = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ]);
        // Verifique se os dados do usuário são válidos
        $this->assertInstanceOf(Usuario::class, $usuario);
        $this->assertNotEmpty($usuario->nome);
        $this->assertNotEmpty($usuario->email);
        $this->assertNotEmpty($usuario->documento);
        $this->assertEquals(Usuario::TIPO_COMUM, $usuario->tipo_usuario_id);
        $this->assertIsFloat($usuario->saldo);
        $this->assertNotEmpty($usuario->senha);
    }

    public function testPodeTransferir()
    {
        $usuarioComum = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ]);

        $usuarioLojista = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'),
            'tipo_usuario_id' => Usuario::TIPO_LOJISTA,
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
            'senha' => $this->faker->password,
        ]);

        $this->assertTrue($usuarioComum->podeTransferir());
        $this->assertFalse($usuarioLojista->podeTransferir());
    }

    public function testTransferir()
    {
        $usuario = new Usuario([
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'), // Supondo que o campo seja um CPF
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 300,
            'senha' => $this->faker->password, // Gera uma senha criptografada aleatória
        ]);
        $usuario->transferir(200);

        $this->assertEquals(100, $usuario->saldo);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Saldo insuficiente para transferência');
        $usuario->transferir(200);
    }

    public function testeReceber()
    {

        $usuario = new Usuario([
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'), // Supondo que o campo seja um CPF
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 300,
            'senha' => $this->faker->password, // Gera uma senha criptografada aleatória
        ]);

        $usuario->receber(200);
        $this->assertEquals(500, $usuario->saldo);
    }

    public function testExceptionValorInvalido()
    {
        $usuario = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'), // Supondo que o campo seja um CPF
            'tipo_usuario_id' => Usuario::TIPO_COMUM,
            'saldo' => 300,
            'senha' => $this->faker->password, // Gera uma senha criptografada aleatória
        ]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Valor inválido para realizar a transação");
        $usuario->transferir(-200);
    }

    public function testExceptionNaoPodeTransferir()
    {
        $usuario = new Usuario([
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'documento' => $this->faker->unique()->numerify('###########'), // Supondo que o campo seja um CPF
            'tipo_usuario_id' => Usuario::TIPO_LOJISTA,
            'saldo' => 300,
            'senha' => $this->faker->password, // Gera uma senha criptografada aleatória
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Apenas usuários comuns podem realizar transferências');
        $usuario->transferir(200);
    }
}
