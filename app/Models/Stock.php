<?php

namespace App\Models;


class Stock
{
    private string $symbol;
    private float $price;
    private int $amount;
    private string $date;
    private string $name;

    public function __construct(
        string $symbol,
        float $price,
        int $amount,
        string $date,
        string $name
    )
    {
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
        $this->date = $date;
        $this->name = $name;
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

    public function date(): string
    {
        return $this->date;
    }

    public function name(): string
    {
        return $this->name;
    }

}