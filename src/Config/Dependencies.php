<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as DB;

use Psr\Container\ContainerInterface;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

$container = $app->getContainer();

$dbsettings = $container->get('settings')['database'];

$capsule = new DB;
$capsule->addConnection($dbsettings);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container["logger"] = function (ContainerInterface $container) {

    $logsettings = $container->get('settings')['logger'];

    $logname = $logsettings['name'];
    $logpath = $logsettings['path'];
    $loglevel = $logsettings['level'];

    $logger = new Logger($logname);

    $formatter = new LineFormatter(
        "[%datetime%] [%level_name%]: %message% %context%\n",
        null,
        true,
        true
    );

    $rotating = new RotatingFileHandler($logpath, 0, $loglevel);
    $rotating->setFormatter($formatter);
    $logger->pushHandler($rotating);

    return $logger;
};
