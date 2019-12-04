<?php

namespace DavegTheMighty\ShoppingBasket\Domain\Manager;

use DavegTheMighty\ShoppingBasket\Domain\Model\Item;

use Illuminate\Support\Collection;

class ItemManager
{
    /**
     * @param  string $item_id
     * @return Item
     */
    public function findById(string $item_id): Item
    {
        return Item::findOrFail($item_id);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Item::all();
    }
}
