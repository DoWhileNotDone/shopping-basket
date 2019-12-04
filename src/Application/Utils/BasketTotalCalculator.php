<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Utils;

use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;

class BasketTotalCalculator
{
    /**
     * @param Basket $basket
     */
    public function updateTotal(Basket $basket) : Basket
    {
        $basket->fill([
            'total' => $basket->items->sum(
                function ($item) {
                    return $item->price * $item->getRelation('basket_item')->quantity;
                }
            )
        ]);
        return $basket;
    }
}
