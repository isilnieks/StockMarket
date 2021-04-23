<?php

namespace App\Controllers;

use App\Services\AddMoneyService;
use App\Services\BuyStockService;
use App\Services\FinnHubService;
use App\Services\OwnedStockService;
use App\Services\RemoveMoneyService;
use App\Services\SellStockService;
use App\Services\WalletService;
use Twig\Environment;

class HomeController
{
    private Environment $environment;
    private OwnedStockService $ownedStock;
    private SellStockService $sellStock;
    private WalletService $wallet;
    private RemoveMoneyService $removeMoney;
    private AddMoneyService $addMoney;
    private FinnHubService $finnHub;
    private BuyStockService $buyStock;

    public function __construct(
        Environment $environment,
        OwnedStockService $ownedStock,
        SellStockService $sellStock,
        WalletService $wallet,
        RemoveMoneyService $removeMoney,
        AddMoneyService $addMoney,
        FinnHubService $finnHub,
        BuyStockService $buyStock
    )
    {
        $this->environment = $environment;
        $this->ownedStock = $ownedStock;
        $this->sellStock = $sellStock;
        $this->wallet = $wallet;
        $this->removeMoney = $removeMoney;
        $this->addMoney = $addMoney;
        $this->finnHub = $finnHub;
        $this->buyStock = $buyStock;

    }

    public function index()
    {
        $stocks = $this->ownedStock->execute();
        $money = $this->wallet->execute();
        $currentPrice = $this->finnHub;

        return $this->environment->render('HomeView.twig',
            ['stocks' => $stocks,
             'money' => $money,
             'currentPrice' => $currentPrice]);
    }

    public function sell()
    {
        if (isset($_POST['sell_symbol']) && isset($_POST['sell_amount'])) {
            $this->sellStock->execute($_POST['sell_symbol'], $_POST['sell_amount']);
            $earnings = $_POST['sell_amount'] * $this->finnHub->price($_POST['sell_symbol']);
            $this->addMoney->execute($earnings);
        }
        return $this->environment->render('SellView.twig');
    }

    public function buy()
    {
        if (isset($_POST['buy_symbol']) && isset($_POST['buy_amount'])) {
            $this->buyStock->execute
            (
                $_POST['buy_symbol'],
                $_POST['buy_amount'],
                $this->finnHub->price($_POST['buy_symbol']),
                $this->finnHub->name($_POST['buy_symbol']
                )
            );
            $totalPrice = $this->finnHub->price($_POST['buy_symbol']) * $_POST['buy_amount'];
            $this->removeMoney->execute($totalPrice);
        }
        return $this->environment->render('BuyView.twig');

    }
}