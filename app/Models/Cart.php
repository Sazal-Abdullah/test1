<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'quantity', 'price', 'discounted_price','total_price', 'user_id'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    // public function getTotalPriceAttribute()
    // {
    //     return $this->quantity * $this->discounted_price;
    // }



}

