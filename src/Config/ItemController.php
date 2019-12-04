<?php declare(strict_types=1);

use DavegTheMighty\ShoppingBasket\Application\Controller\ItemController;
use DavegTheMighty\ShoppingBasket\Application\Service\ItemService;

use DavegTheMighty\ShoppingBasket\Domain\Manager\ItemManager;

use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container["ItemController"] = function (ContainerInterface $container) {

    $manager = new ItemManager();

    $service = new ItemService();
    $service->setItemManager($manager);

    $controller = new ItemController();
    $controller->setLogger($container->logger);
    $controller->setService($service);

    return $controller;
};
