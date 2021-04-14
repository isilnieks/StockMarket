<?php

namespace App\Services;

use App\Repositories\StocksRepository;

class SellStockService
{
    private StocksRepository $repository;

    public function __construct(StocksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $symbol, int $amount): void
    {
        $this->repository->sell($symbol, $amount);
    }
}