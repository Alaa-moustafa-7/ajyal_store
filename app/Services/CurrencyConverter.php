<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'https://v6.exchangerate-api.com/v6';
    //  https://v6.exchangerate-api.com/v6/e78a17d96a7bc3591bd49a51/latest/USD

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from, string $to, float $amount = 1) : float
    {

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/latest/{$from}");
        $result = $response->json();
        return $result['conversion_rates'][$to] * $amount;
    }
}