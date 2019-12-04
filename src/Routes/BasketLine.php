<?php declare(strict_types=1);

$app->put(
    '/baskets/{basket_id}/items/{item_id}',
    \BasketLineController::class . ':addItem'
)
->setName('addItemToBasket');

$app->delete(
    '/baskets/{basket_id}/items/{item_id}',
    \BasketLineController::class . ':removeItem'
)
->setName('removeItemFromBasket');
