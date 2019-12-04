<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Domain\Factory\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * @return Uuid
     */
    public static function generateId(): Uuid
    {
        return Uuid::uuid4();
    }
}
