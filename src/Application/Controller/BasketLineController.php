<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Controller;

use DavegTheMighty\ShoppingBasket\Application\Service\BasketLineService;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class BasketLineController extends BaseController
{
    /**
     * @var BasketLineService
     */
    private $basketLineService;

    /**
     * @param BasketLineService $service
     */
    public function setService(BasketLineService $service) : void
    {
        $this->basketLineService = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function addItem(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $basket_id = $args['basket_id'];
            $item_id = $args['item_id'];
            $quantity = (int) $request->getQueryParam('quantity', 1);

            $this->basketLineService->addItem($basket_id, $item_id, $quantity);
            return $response->withStatus(201);
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
    public function removeItem(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $basket_id = $args['basket_id'];
            $item_id = $args['item_id'];
            $quantity = (int) $request->getQueryParam('quantity', 1);

            $this->basketLineService->removeItem($basket_id, $item_id, $quantity);
            return $response->withStatus(200);
        } catch (\Throwable $e) {
            return $this->handlerError($request, $response, $e);
        }
    }
}
