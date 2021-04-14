<?php

namespace App\Services;

use App\Repositories\FinnHubRepository;

class PriceService
{
    private FinnHubRepository $repository;

    public function __construct(FinnHubRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $symbol): float
    {
        return $this->repository->price($symbol);
    }
}