<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductApplicationImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductApplication extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id', 'title', 'description', 'price', 'sku', 'barcode', 'inventory', 'status'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductApplicationImage::class, 'product_application_id');
    }
}
