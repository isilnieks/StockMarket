<?php

namespace App\Services;

use App\Repositories\WalletRepository;

class WalletService
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): float
    {
        return $this->repository->wallet();
    }
}