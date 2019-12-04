<?php

namespace DavegTheMighty\ShoppingBasket\Test\Unit\Application\Service;

use DavegTheMighty\ShoppingBasket\Application\Service\ItemService;
use DavegTheMighty\ShoppingBasket\Domain\Manager\ItemManager;
use DavegTheMighty\ShoppingBasket\Domain\Model\Item;

use PHPUnit\Framework\TestCase;

final class ItemServiceTest extends TestCase
{

    /**
     * @var ItemService
     */
    private $subject;

    /**
     * @var MockObject|ItemManager
     */
    private $itemManager;

    /**
     * @var MockObject|Item
     */
    private $item;

    public function setUp() : void
    {
        $this->subject = new ItemService();
        $this->itemManager = $this->createMock(ItemManager::class);
        $this->subject->setItemManager($this->itemManager);
        $this->item = $this->createMock(Item::class);
    }

    public function testGetOne(): void
    {
        $this->itemManager
            ->expects($this->once())
            ->method('findById')
            ->with('ac7ffed0-0aaf-4f0b-81a3-a648bfebb3af')
            ->willReturn($this->item);

        $this->assertEquals($this->subject->getOne('ac7ffed0-0aaf-4f0b-81a3-a648bfebb3af'), $this->item);
    }

    public function testGetAll(): void
    {
        $this->itemManager
            ->expects($this->once())
            ->method('findAll')
            ->willReturn(collect([$this->item]));

        $this->assertEquals($this->subject->getAll(), collect([$this->item]));
    }
}
