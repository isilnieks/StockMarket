<?php

namespace App\Services;

use App\Repositories\WalletRepository;

class RemoveMoneyService
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(float $money): void
    {
        $this->repository->removeMoney($money);
    }
}

