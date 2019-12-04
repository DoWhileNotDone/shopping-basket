<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Domain\Factory;

use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;

final class BasketFactory
{
    use Traits\UuidTrait;

    /**
     * @param  array|null $body
     * @return Basket
     */
    public static function create(array $body = null): Basket
    {
        $basket = new Basket(["id" => self::generateId()]);
        if ($body !== null) {
            $basket->fill($body);
        }
        return $basket;
    }
}
