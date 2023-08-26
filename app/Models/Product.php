<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'desc',
        'price',
        'discount',
        'category_id',
        'vendor_id',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

}
