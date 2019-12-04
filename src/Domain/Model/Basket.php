<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Domain\Model;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{

    public $incrementing = false;

    protected $fillable = [
      'id',
      'total',
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    protected $with = [
        'items',
    ];

    public function contains(Item $item): bool
    {
        return true;
    }

    public function items()
    {
        return $this->belongsToMany(
            'DavegTheMighty\ShoppingBasket\Domain\Model\Item',
            'basket_lines',
            'basket_id',
            'item_id'
        )
        ->withPivot('quantity')
        ->as('basket_item');
    }
}
