<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // Define the relationship
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Define the relationship with the Product model (if applicable)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
