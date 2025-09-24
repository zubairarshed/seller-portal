<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductApplicationImage;

class ProductApplicationImage extends Model
{
    protected $fillable = ['product_application_id', 'image_path'];

    public function application()
    {
        return $this->belongsTo(ProductApplication::class, 'product_application_id');
    }
}
