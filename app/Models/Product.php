<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'title', 'description', 'price', 'sku', 'barcode', 'inventory'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
