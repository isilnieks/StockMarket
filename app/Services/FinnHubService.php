<?php

namespace App\Services;

use App\Repositories\FinnHubRepository;

class FinnHubService
{
    private FinnHubRepository $repository;

    public function __construct(FinnHubRepository $repository)
    {
        $this->repository = $repository;
    }

    public function price(string $symbol): float
    {
        return $this->repository->price($symbol);
    }

    public function name(string $symbol): string
    {
        return $this->repository->name($symbol);
    }
}