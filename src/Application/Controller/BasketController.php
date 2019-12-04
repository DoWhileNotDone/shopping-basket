<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Controller;

use DavegTheMighty\ShoppingBasket\Application\Service\BasketService;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class BasketController extends BaseController
{
    /**
     * @var BasketService
     */
    private $basketService;

    /**
     * @param BasketService $service
     */
    public function setService(BasketService $service) : void
    {
        $this->basketService = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getAll(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $baskets = $this->basketService->getAll();
            return $response->withJson($baskets)->withStatus(200);
        } catch (\Throwable $e) {
            return $this->handlerError($request, $response, $e);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getOne(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $basket = $this->basketService->getOne($args['basket_id']);
            return $response->withJson($basket)->withStatus(200);
        } catch (\Throwable $e) {
            return $this->handlerError($request, $response, $e);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function post(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $basket = $this->basketService->create();
            return $response->withStatus(201)->withAddedHeader('Location', 'baskets/'.$basket->id);
        } catch (\Throwable $e) {
            return $this->handlerError($request, $response, $e);
        }
    }
}
