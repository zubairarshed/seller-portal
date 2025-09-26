<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function sellers()
    {
        return $this->belongsToMany(
            User::class,
            'order_items',
            'order_id',
            'seller_id'
        )->distinct();
    }
}
    