<?php declare(strict_types=1);

use DavegTheMighty\ShoppingBasket\Application\Controller\BasketController;
use DavegTheMighty\ShoppingBasket\Application\Service\BasketService;
use DavegTheMighty\ShoppingBasket\Application\Utils\BasketTotalCalculator;

use DavegTheMighty\ShoppingBasket\Domain\Manager\BasketManager;
use DavegTheMighty\ShoppingBasket\Domain\Repository\BasketRepository;

use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container["BasketController"] = function (ContainerInterface $container) {

    $manager = new BasketManager(
        new BasketTotalCalculator(),
        new BasketRepository()
    );

    $service = new BasketService();
    $service->setBasketManager($manager);

    $controller = new BasketController();
    $controller->setLogger($container->logger);
    $controller->setService($service);

    return $controller;
};
