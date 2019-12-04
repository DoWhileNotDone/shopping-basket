<?php declare(strict_types=1);

require __DIR__ . "/src/Config/Dependencies.php";

require __DIR__ . "/src/Config/BasketController.php";
require __DIR__ . "/src/Config/BasketLineController.php";
require __DIR__ . "/src/Config/ItemController.php";

//Define Routes
require __DIR__ . "/src/Routes/Basket.php";
require __DIR__ . "/src/Routes/BasketLine.php";
require __DIR__ . "/src/Routes/Item.php";
