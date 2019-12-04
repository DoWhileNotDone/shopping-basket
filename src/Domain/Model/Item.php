<?php declare(strict_types=1);

namespace DavegTheMighty\ShoppingBasket\Domain\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $incrementing = false;

    protected $fillable = [
      'id',
      'name',
      'price',
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function baskets()
    {
        return $this->belongsToMany(
            'DavegTheMighty\ShoppingBasket\Domain\Model\Basket',
            'basket_lines',
            'item_id',
            'basket_id'
        )
        ->withPivot('quantity')
        ->as('basket_item');
    }
}
