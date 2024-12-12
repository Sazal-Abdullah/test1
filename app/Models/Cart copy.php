<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'quantity', 'price', 'discounted_price', 'user_id'];

    protected $appends = ['total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // App\Models\Cart.php

public static function getTotalAmount($userId)
{
    $cartItems = self::where('user_id', $userId)->get(); // Get cart items for the specified user
    $total = 0;

    foreach ($cartItems as $item) {
        // Assuming 'discounted_price' and 'quantity' are properties on the Cart model
        $total += $item->quantity * $item->discounted_price;
    }

    return $total;
}




}

