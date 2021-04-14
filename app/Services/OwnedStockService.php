<?php

namespace App\Services;

use App\Repositories\StocksRepository;

class OwnedStockService
{
    private StocksRepository $repository;

    public function __construct(StocksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->ownedStocks();
    }
}