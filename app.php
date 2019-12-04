<?php declare(strict_types=1);

date_default_timezone_set("UTC");

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->overload();

// Instantiate the app
// Composer Autoloader does not work for functions/constants, so rather than
// wrapping the settings in an arbitrary class, we use a require statement.
$application_settings = require __DIR__ . '/src/Config/Settings.php';

// To be correctly placed in the app settings, the sub array is required
if ($application_settings['settings']['displayErrorDetails']) {
    error_reporting(E_ALL);
    ini_set("display_errors", "true");
}

$app = new \Slim\App($application_settings);

require __DIR__ . "/requires.php";

$app->run();
