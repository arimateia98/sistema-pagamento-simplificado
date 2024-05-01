<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class AutorizacaoService
{
    /**
     * Obtém a autorização da transferência
     *
     * @return array Os dados de autorização obtidos da API
     * @throws Exception Quando ocorre um erro ao obter a autorização.
     */
    public static function obterAutorizacao() : mixed
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

            if ($response->successful()) {
                return $response->json();
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao obter os dados da API externa: ' . $e->getMessage());
        }
    }
}
