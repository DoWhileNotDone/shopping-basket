<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Application\Service;

use DavegTheMighty\ShoppingBasket\Domain\Model\Item;
use DavegTheMighty\ShoppingBasket\Domain\Manager\ItemManager;

use Illuminate\Support\Collection;

class ItemService
{
    /**
     * @var ItemManager
     */
    protected $itemManager;

    /**
     * @param ItemManager $itemManager
     */
    public function setItemManager(ItemManager $itemManager) : void
    {
        $this->itemManager = $itemManager;
    }

    /**
     * @param  string $item_id
     * @return Item
     */
    public function getOne(string $item_id) : Item
    {
        $item = $this->itemManager->findById($item_id);
        return $item;
    }

    /**
     * @return Collection
     */
    public function getAll() : Collection
    {
        return $this->itemManager->findAll();
    }
}
