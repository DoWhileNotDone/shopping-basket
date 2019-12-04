<?php

namespace DavegTheMighty\ShoppingBasket\Domain\Repository;

use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;
use DavegTheMighty\ShoppingBasket\Domain\Model\Item;

class BasketRepository
{
    /**
     * @param  Basket $basket
     * @param  Item   $item
     * @return int
     */
    public function getItemQuantity(Basket $basket, Item $item): int
    {
        return $basket->getRelation('items')->find($item)->getRelation('basket_item')->quantity;
    }
}
