<?php

namespace App\Repositories;

use Medoo\Medoo;

class WalletRepository
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

    public function wallet(): float
    {
        $money = $this->database->select('wallet', 'money');
        return $money[0];
    }

    public function removeMoney(float $money): void
    {
        $amount = $this->wallet() - $money;
        $this->database->update('wallet',[
            'money' => $amount
        ]);
    }

    public function addMoney(float $money): void
    {
        $amount = $this->wallet() + $money;
        $this->database->update('wallet',[
            'money' => $amount
        ]);
    }

}
