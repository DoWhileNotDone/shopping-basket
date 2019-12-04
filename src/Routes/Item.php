<?php declare(strict_types=1);

$app->get(
    '/items/{item_id}',
    \ItemController::class . ':getOne'
)
->setName('getItem');

$app->get(
    '/items',
    \ItemController::class . ':getAll'
)
->setName('getAllItems');
