<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Service;

use DavegTheMighty\ShoppingBasket\Domain\Manager\ItemManager;
use DavegTheMighty\ShoppingBasket\Domain\Manager\BasketManager;

class BasketLineService
{

    /**
     * @var ItemManager
     */
    protected $itemManager;

    /**
     * @var BasketManager
     */
    protected $basketManager;

    /**
     * @param ItemManager $itemManager
     */
    public function setItemManager(ItemManager $itemManager) : void
    {
        $this->itemManager = $itemManager;
    }

    /**
     * @param BasketManager $basketManager
     */
    public function setBasketManager(BasketManager $basketManager) : void
    {
        $this->basketManager = $basketManager;
    }

    /**
     * @param string $basket_id
     * @param string $item_id
     * @param integer $quantity
     */
    public function addItem(
        string $basket_id,
        string $item_id,
        int $quantity = 1
    ): void {
        $basket = $this->basketManager->findById($basket_id);
        $item = $this->itemManager->findById($item_id);
        //TODO: Consider where this should be located
        //TODO: Consider if these should be atomic
        $basket = $this->basketManager->addItem($basket, $item, $quantity);
        $basket = $this->basketManager->updateBasketTotals($basket->fresh());
        $this->basketManager->save($basket);
    }

    /**
     * @param string $basket_id
     * @param string $item_id
     * @param int $quantity
     */
    public function removeItem(
        string $basket_id,
        string $item_id,
        int $quantity = 1
    ): void {
        $basket = $this->basketManager->findById($basket_id);
        $item = $this->itemManager->findById($item_id);

        //TODO: Consider where this should be located
        //TODO: Consider if these should be atomic
        $basket = $this->basketManager->removeItem($basket, $item, $quantity);
        $basket = $this->basketManager->updateBasketTotals($basket->fresh());
        $this->basketManager->save($basket);
    }
}
