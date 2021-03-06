<?php

namespace App\Repositories;

interface StocksRepository
{
    public function buy(string $symbol, int $amount, float $price, string $name): void;
    public function sell(string $symbol,int $amount): void;
    public function ownedStocks(): array;


}