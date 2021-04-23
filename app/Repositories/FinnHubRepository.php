<?php

namespace App\Repositories;

use Finnhub;
use GuzzleHttp;

class FinnHubRepository
{
    private Finnhub\Configuration $config;
    private Finnhub\Api\DefaultApi $client;

    public function __construct()
    {
        $this->config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c1orv8iad3ic1jomudr0');
        $this->client = new Finnhub\Api\DefaultApi(
            new GuzzleHttp\Client(),
            $this->config
        );
    }

    public function price(string $symbol)
    {
        $symbol = strtoupper($symbol);
        return $this->client->quote($symbol)["c"];
    }

    public function name(string $symbol)
    {
        return $this->client->companyProfile2($symbol)["name"];
    }
}