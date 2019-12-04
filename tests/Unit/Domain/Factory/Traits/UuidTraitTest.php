<?php

namespace DavegTheMighty\ShoppingBasket\Test\Unit\Domain\Factory\Traits;

use DavegTheMighty\ShoppingBasket\Domain\Factory\Traits\UuidTrait;
use Ramsey\Uuid\Uuid;

use PHPUnit\Framework\TestCase;

final class UuidTraitTest extends TestCase
{
    /**
     * @var Closure
     */
    private $subject;

    public function setUp() : void
    {
        $this->subject = new class() {
            use UuidTrait;
        };
    }

    public function testGenerateId(): void
    {
        $id = $this->subject->generateId();
        $this->assertInstanceOf(Uuid::class, $id);
    }
}
