<?php declare(strict_types=1);

use DavegTheMighty\ShoppingBasket\Application\Controller\BasketLineController;
use DavegTheMighty\ShoppingBasket\Application\Service\BasketLineService;
use DavegTheMighty\ShoppingBasket\Application\Utils\BasketTotalCalculator;

use DavegTheMighty\ShoppingBasket\Domain\Manager\BasketManager;
use DavegTheMighty\ShoppingBasket\Domain\Manager\ItemManager;
use DavegTheMighty\ShoppingBasket\Domain\Repository\BasketRepository;

use Psr\Container\ContainerInterface;
use Valitron\Validator;

$container = $app->getContainer();

$container["BasketLineController"] = function (ContainerInterface $container) {

    $itemManager = new ItemManager();
    $basketManager = new BasketManager(
        new BasketTotalCalculator(),
        new BasketRepository()
    );

    $service = new BasketLineService();
    $service->setItemManager($itemManager);
    $service->setBasketManager($basketManager);

    $controller = new BasketLineController();
    $controller->setLogger($container->logger);
    $controller->setService($service);

    return $controller;
};
