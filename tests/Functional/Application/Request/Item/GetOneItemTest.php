<?php

namespace DavegTheMighty\ShoppingBasket\Test\Functional\Domain\Request\Item;

use PHPUnit\Framework\TestCase;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

use Slim\App;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;

final class GetOneItemTest extends TestCase
{
    /**
     * @var App
     */
    private $app;

    public function setUp() : void
    {
        $this->app = $this->setUpApp();
        $this->setUpTables();
    }

    private function setUpTables() : void
    {
        DB::schema()->create('items', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name');
                $table->decimal('price');
                $table->primary('id');
        });

        DB::schema()->create('baskets', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');
        });

        DB::schema()->create('basket_lines', function (Blueprint $table) {
                $table->uuid('basket_id');
                $table->uuid('item_id');
                $table->integer('quantity');
        });

        DB::table('items')->insert([
            [
                'id' => '2b68ecfe-b00f-4574-9f0d-4a87f6e5f0d6',
                'name' => 'Beans',
                'price' => 5.99,
            ],
            [
                'id' => '903cd4e9-1d44-47b9-8b50-abdbe57016c0',
                'name' => 'Spam',
                'price' => 3.50,
            ]
        ]);

        DB::table('baskets')->insert([
            ['id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47'],
        ]);

        DB::table('basket_lines')->insert([
            [
                'basket_id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47',
                'item_id' => '2b68ecfe-b00f-4574-9f0d-4a87f6e5f0d6',
                'quantity' => 1,
            ],
            [
                'basket_id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47',
                'item_id' => '903cd4e9-1d44-47b9-8b50-abdbe57016c0',
                'quantity' => 2,
            ],
        ]);
    }

    private function setupRequest(string $method, string $url) : Request
    {
        $env = Environment::mock([
            'REQUEST_METHOD'    => $method,
            'REQUEST_URI'       => $url
        ]);

        $uri = Uri::createFromEnvironment($env);

        $headers = Headers::createFromEnvironment($env);
        $body = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        return new Request($method, $uri, $headers, [], [], $body);
    }

    private function setupApp() : App
    {
        $app_root = __DIR__.'/../../../../../';
        $applicationsettings = [
            'settings' => [
                'determineRouteBeforeAppMiddleware' => true,
                'database' => [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => ''
                ],
                'logger' => [
                    'name' => 'shoppingbasket',
                    'path' => $app_root.'var/logs/shoppingbasket.log',
                    'level' => getenv('LOG_LEVEL') ?: \Psr\Log\LogLevel::DEBUG,
                ],
            ]
        ];
        $container = new Container($applicationsettings);
        $app = new App($container);

        require_once $app_root.'requires.php';

        return $app;
    }

    public function testGetOne(): void
    {
        $request = $this->setUpRequest('GET', '/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0');

        $response = $this->app->process(
            $request,
            new Response()
        );

        $this->assertEquals($response->getStatusCode(), 200);
        $response_item = json_decode((string) $response->getBody(), true);

        $this->assertEquals($response_item['id'], '903cd4e9-1d44-47b9-8b50-abdbe57016c0');
        $this->assertEquals($response_item['name'], 'Spam');
        $this->assertEquals($response_item['price'], 3.50);
    }
}
