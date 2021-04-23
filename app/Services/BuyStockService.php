<?php

namespace App\Services;

use App\Repositories\StocksRepository;

class BuyStockService
{
    private StocksRepository $repository;

    public function __construct(StocksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $symbol, int $amount, float $price, string $name): void
    {
        $this->repository->buy($symbol, $amount, $price, $name);
    }

}
