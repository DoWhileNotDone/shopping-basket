<?php declare(strict_types=1);

$app->get(
    '/baskets/{basket_id}',
    \BasketController::class . ':getOne'
)
->setName('getBasket');

$app->get(
    '/baskets',
    \BasketController::class . ':getAll'
)
->setName('getAllBaskets');

$app->post(
    '/baskets',
    \BasketController::class . ':post'
)
->setName('createBasket');
