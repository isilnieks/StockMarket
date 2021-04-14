<?php

namespace App\Services;

use App\Repositories\FinnHubRepository;
use App\Repositories\StocksRepository;
use App\Repositories\WalletRepository;

class StockService
{
    private StocksRepository $repository;
    private FinnHubRepository $finnhub;


    public function __construct(StocksRepository $repository, FinnHubRepository $finnhub)
    {
        $this->repository = $repository;
        $this->finnhub = $finnhub;
    }

    public function ownedStocks(): array
    {
        return $this->repository->ownedStocks();
    }

    public function sell(string $symbol, int $amount): void
    {
        $this->repository->sell($symbol, $amount);
    }

    public function buy(string $symbol, int $amount): void
    {
        $price = $this->finnhub->price($symbol);
        $this->repository->buy($symbol, $amount, $price);
    }


}