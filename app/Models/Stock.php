<?php

namespace App\Models;


class Stock
{
    private string $symbol;
    private float $price;
    private int $amount;

    public function __construct(
        string $symbol,
        float $price,
        int $amount)
    {
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function amount(): int
    {
        return $this->amount;
    }


}