<?php


require '../vendor/autoload.php';

use App\Repositories;


$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c1orv8iad3ic1jomudr0');
$client = new Finnhub\Api\DefaultApi(
    new GuzzleHttp\Client(),
    $config
);

echo ($client->quote('AAPL')["c"]);

$a = new Repositories\WalletRepository();
//$a->addMoney(100.55);
$b = new Repositories\MySQLStocksRepository();
var_dump($b->ownedStocks());

