<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Controller;

use DavegTheMighty\ShoppingBasket\Domain\Validation\Exception\ModelValidationError;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseController
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger) : void
    {
        $this->logger = $logger;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  Throwable              $error
     * @return ResponseInterface
     */
    public function handlerError(
        ServerRequestInterface $request,
        ResponseInterface $response,
        \Throwable $error
    ) : ResponseInterface {
        try {
            $context = [
                'Method' => $request->getMethod(),
                'Route' => $request->getUri()->getPath(),
                'Exception' => $error,
            ];
            throw $error;
        } catch (ModelValidationError $e) {
            $this->logger->info("Validation errors raised for request", $context);
            return $response->withJson($e->getErrors())->withStatus(400);
        } catch (ModelNotFoundException $e) {
            $this->logger->info("Resource not found for request", $context);
            return $response->withStatus(404);
        } catch (\PDOException $e) {
            $this->logger->info("Unable to perform database transaction", $context);
            return $response->withStatus(500);
        } catch (\RuntimeException $e) {
            $this->logger->info("Unable to complete request", $context);
            return $response->withStatus(500);
        }
    }
}
