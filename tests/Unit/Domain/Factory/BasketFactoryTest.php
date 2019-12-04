<?php

namespace DavegTheMighty\ShoppingBasket\Test\Unit\Domain\Factory;

use DavegTheMighty\ShoppingBasket\Domain\Factory\BasketFactory;
use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;
use PHPUnit\Framework\TestCase;

final class BasketFactoryTest extends TestCase
{
    public function testCreateWithoutBody(): void
    {
        $object = BasketFactory::create(null);

        $this->assertInstanceOf(Basket::class, $object);
        $this->assertNotEmpty($object->id);
    }
}
