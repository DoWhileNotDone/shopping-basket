<?php

namespace DavegTheMighty\ShoppingBasket\Domain\Manager;

use DavegTheMighty\ShoppingBasket\Application\Utils\BasketTotalCalculator;

use DavegTheMighty\ShoppingBasket\Domain\Factory\BasketFactory;
use DavegTheMighty\ShoppingBasket\Domain\Model\Basket;
use DavegTheMighty\ShoppingBasket\Domain\Model\Item;
use DavegTheMighty\ShoppingBasket\Domain\Repository\BasketRepository;

use Illuminate\Support\Collection;

class BasketManager
{
    /**
     * @var BasketTotalCalculator
     */
    private $basketTotalCalculator;

    /**
     * @var BasketRepository
     */
    private $basketRepository;

    public function __construct(
        BasketTotalCalculator $basketTotalCalculator,
        BasketRepository $basketRepository
    ) {
        $this->basketTotalCalculator = $basketTotalCalculator;
        $this->basketRepository = $basketRepository;
    }

    /**
     * @param  string $basket_id
     * @return Basket
     */
    public function findById(string $basket_id): Basket
    {
        return Basket::findOrFail($basket_id);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Basket::all();
    }

    /**
     * @param array $data
     * @return Basket
     */
    public function create(array $data = null): Basket
    {
        return BasketFactory::create($data);
    }

    /**
     * @param  Basket $basket
     * @param  Item   $item
     * @return Basket
     */
    public function addItem(Basket $basket, Item $item, int $quantity = 1): Basket
    {
        if ($basket->getRelation('items')->contains($item)) {
            $existing_quantity = $this->basketRepository->getItemQuantity($basket, $item);
            $basket->items()->updateExistingPivot(
                $item,
                ['quantity' => ($existing_quantity + $quantity)]
            );
        } else {
            $basket->items()->attach($item, ['quantity' => $quantity]);
        }
        return $basket;
    }

    /**
     * @param  Basket $basket
     * @param  Item   $item
     * @return Basket
     */
    public function removeItem(Basket $basket, Item $item, int $quantity = 1): Basket
    {
        if ($basket->items->contains($item)) {
            $existing_quantity = $this->basketRepository->getItemQuantity($basket, $item);
            if ($existing_quantity <= $quantity) {
                $basket->items()->detach($item);
            } else {
                $basket->items()->updateExistingPivot(
                    $item,
                    ['quantity' => ($existing_quantity - $quantity)]
                );
            }
        }
        return $basket;
    }

    /**
     * @param  Basket $basket
     * @return Basket
     */
    public function updateBasketTotals(Basket $basket) : Basket
    {
        return $this->basketTotalCalculator->updateTotal($basket);
    }

    /**
     * @param Basket $basket
     * @return Basket
     */
    public function save(Basket $basket): Basket
    {
        $basket->save();
        return $basket;
    }
}
