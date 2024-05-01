<?php

namespace Tests\Unit;

use App\Http\Services\AutorizacaoService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AutorizacaoTest extends TestCase
{
    public function testAutorizacao()
    {

        $response = AutorizacaoService::obterAutorizacao();
        $this->assertEquals(['message' => 'Autorizado'], $response);
    }
}
