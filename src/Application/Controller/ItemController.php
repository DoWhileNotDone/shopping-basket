<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Controller;

use DavegTheMighty\ShoppingBasket\Application\Service\ItemService;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class ItemController extends BaseController
{
    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * @param ItemService $service
     */
    public function setService(ItemService $service) : void
    {
        $this->itemService = $service;
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
            $items = $this->itemService->getAll();
            return $response->withJson($items)->withStatus(200);
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
            $item_id = $args['item_id'];
            $item = $this->itemService->getOne($item_id);
            return $response->withJson($item)->withStatus(200);
        } catch (\Throwable $e) {
            return $this->handlerError($request, $response, $e);
        }
    }
}
