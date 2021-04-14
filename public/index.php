<?php

require_once "../vendor/autoload.php";

use App\Controllers\HomeController;
use App\Repositories\FinnHubRepository;
use App\Repositories\MySQLStocksRepository;
use App\Repositories\StocksRepository;
use App\Repositories\WalletRepository;
use App\Services\AddMoneyService;
use App\Services\BuyStockService;
use App\Services\OwnedStockService;
use App\Services\PriceService;
use App\Services\RemoveMoneyService;
use App\Services\SellStockService;
use App\Services\WalletService;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


$loader = new FilesystemLoader('../app/Views');
$twig = new Environment($loader, [
    'debug' => true,
]);
$twig->addExtension(new DebugExtension());

//Container
$container = new League\Container\Container;

$container->add(StocksRepository::class, MySQLStocksRepository::class);
$container->add(FinnHubRepository::class, FinnHubRepository::class);
$container->add(WalletRepository::class, WalletRepository::class);

$container->add(OwnedStockService::class, OwnedStockService::class)
    ->addArgument(StocksRepository::class);
$container->add(SellStockService::class, SellStockService::class)
    ->addArgument(StocksRepository::class);
$container->add(WalletService::class, WalletService::class)
    ->addArgument(WalletRepository::class);
$container->add(RemoveMoneyService::class, RemoveMoneyService::class)
    ->addArgument(WalletRepository::class);
$container->add(AddMoneyService::class, AddMoneyService::class)
    ->addArgument(WalletRepository::class);
$container->add(PriceService::class, PriceService::class)
    ->addArgument(FinnHubRepository::class);
$container->add(BuyStockService::class, BuyStockService::class)
    ->addArgument(StocksRepository::class);


$container->add(HomeController::class, HomeController::class)
    ->addArguments([
        $twig,
        OwnedStockService::class,
        SellStockService::class,
        WalletService::class,
        RemoveMoneyService::class,
        AddMoneyService::class,
        PriceService::class,
        BuyStockService::class
    ]);

//Routes
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/buy', [HomeController::class, 'buy']);
    $r->addRoute('POST', '/buy', [HomeController::class, 'buy']);
    $r->addRoute('GET', '/sell', [HomeController::class, 'sell']);
    $r->addRoute('POST', '/sell', [HomeController::class, 'sell']);

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        echo ($container->get($controller))->$method($vars);
        break;
}