<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Service;

use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;
use DavegTheMighty\ShoppingBasket\Domain\Manager\BasketManager;

use Illuminate\Support\Collection;

class BasketService
{
    /**
     * @var BasketManager
     */
    protected $basketManager;

    /**
     * @param BasketManager $basketManager
     */
    public function setBasketManager(BasketManager $basketManager) : void
    {
        $this->basketManager = $basketManager;
    }

    /**
     * @param  string $basket_id
     * @return Basket
     */
    public function getOne(string $basket_id) : Basket
    {
        $basket = $this->basketManager->findById($basket_id);
        return $basket;
    }

    /**
     * @return Collection
     */
    public function getAll() : Collection
    {
        return $this->basketManager->findAll();
    }

    /**
     * @param  array $body
     * @return Basket
     */
    public function create() : Basket
    {
        $basket = $this->basketManager->create();
        return $this->basketManager->save($basket);
    }
}
