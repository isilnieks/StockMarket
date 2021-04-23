<?php

namespace App\Repositories;

use App\Models\Stock;
use Medoo\Medoo;

class MySQLStocksRepository implements StocksRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'codelex',
            'server' => '127.0.0.1',
            'username' => 'root',
            'password' => 'root'
        ]);
    }

    public function buy(string $symbol, int $amount, float $price, string $name): void
    {
        $symbol = strtoupper($symbol);
        $this->database->insert('stocks', [
            'symbol' => $symbol,
            'amount' => $amount,
            'price' => $price,
            'date' => date("Y/m/d", time()),
            'name' => $name
        ]);
    }

    public function sell(string $symbol, int $amount): void
    {
        $symbol = strtoupper($symbol);
        $ownedAmount = $this->database->select('stocks',
        'amount',
        ['symbol' => $symbol]);
        $total = $ownedAmount[0] - $amount;
        $this->database->update('stocks',
        ['amount' => $total],
        ['symbol'=> $symbol]);
    }

    public function ownedStocks(): array
    {
        foreach($this->database->select('stocks', '*') as $stock)
        {
            $allStocks[] = new Stock($stock['symbol'],$stock['price'],$stock['amount'],$stock['date'], $stock['name']);
        }
        return $allStocks;
    }


}