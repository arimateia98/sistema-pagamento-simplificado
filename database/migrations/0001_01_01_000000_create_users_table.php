<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up(): void
    {

        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('tipos_usuario');

        Schema::create(
            'tipos_usuario', function (Blueprint $table) {
                $table->id();
                $table->string('tipo');
            }
        );


        //inserindo tipos de usuario
        DB::table('tipos_usuario')->insert(
            [
            ['tipo' => 'Comum'],
            ['tipo' => 'Lojista'],
            ]
        );

        Schema::create(
            'usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('email')->unique();
                $table->string('documento')->unique();
                $table->unsignedBigInteger('tipo_usuario_id');
                $table->foreign('tipo_usuario_id')->references('id')->on('tipos_usuario');
                $table->string('senha');
                $table->float('saldo')->default(0);
                $table->rememberToken();
                $table->timestamps();
            }
        );

        Schema::create(
            'password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            }
        );

        Schema::create(
            'sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            }
        );




    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {

        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('tipos_usuario');

        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
}
