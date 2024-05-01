<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class AutorizacaoService
{
    public static function obterAutorizacao()
    {
        try {
            // Fazendo uma requisição GET para a API externa
            $response = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

            // Verificando se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json();
            }
        } catch (Exception $e) {
            // Lidando com exceções
            throw new Exception('Erro ao obter os dados da API externa: ' . $e->getMessage());
        }
    }
}
