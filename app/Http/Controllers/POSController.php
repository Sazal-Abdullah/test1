<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class POSController extends Controller
{

    public function index(Request $request)
{
    $products = Product::query();

    if ($request->has('search')) {
        $products->where('name', 'like', '%' . $request->search . '%')
                 ->orWhere('sku', 'like', '%' . $request->search . '%');
    }

    $products = $products->paginate(10);

    $cartItems = Cart::where('user_id', auth()->id())->get(); // Authenticated user's cart

    return view('admin.pages.pos.index', compact('products', 'cartItems'));
}



public function addToCart(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric',
        'discounted_price' => 'required|numeric',
    ]);

    // Calculate total price
    $totalPrice = $validated['quantity'] * $validated['discounted_price'];


    // Update or create cart item
    $cartItem = Cart::updateOrCreate(
        [
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
        ],
        [
            'name' => $request->input('name'),
            'quantity' => \DB::raw("quantity + {$validated['quantity']}"), // Increment quantity
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'],
            'total_price' => $totalPrice, // Save total price
        ]
    );

    // Fetch updated cart for frontend
    $updatedCart = Cart::where('user_id', auth()->id())->with('product')->get();

    return response()->json([
        'success' => true,
        'message' => 'Product added to cart successfully!',
        'cartItem' => $cartItem,
        'cart' => $updatedCart,
    ]);
}



public function updateCartQuantity(Request $request)
{
    $validated = $request->validate([
        'cart_id' => 'required|exists:carts,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Fetch the cart item
    $cartItem = Cart::find($validated['cart_id']);

    if ($cartItem) {
        // Update quantity and total price
        $cartItem->quantity = $validated['quantity'];
        $cartItem->total_price = $cartItem->quantity * $cartItem->discounted_price;
        $cartItem->save();

        // Fetch updated cart
        $updatedCart = Cart::where('user_id', auth()->id())->with('product')->get();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $updatedCart,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Cart item not found!',
    ]);
}

public function removeCartItem(Request $request)
{
    $validated = $request->validate([
        'cart_id' => 'required|exists:carts,id',
    ]);

    // Find the cart item and delete it
    $cartItem = Cart::find($validated['cart_id']);

    if ($cartItem) {
        $cartItem->delete();

        // Fetch updated cart
        $updatedCart = Cart::where('user_id', auth()->id())->with('product')->get();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully!',
            'cart' => $updatedCart,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Cart item not found!',
    ]);
}






// public function createOrder(Request $request)
// {
//     $userId = auth()->id();

//     // Fetch the cart items for the user
//     $cartItems = Cart::where('user_id', $userId)->get();

//     if ($cartItems->isEmpty()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Your cart is empty!',
//         ]);
//     }

//     \DB::beginTransaction();

//     try {
//         // Calculate total amount
//         $totalAmount = $cartItems->sum(function ($item) {
//             return $item->quantity * ($item->discounted_price ?? $item->price);
//         });

//         // Create a new order
//         $order = Order::create([
//             'user_id' => $userId,
//             'total_amount' => $totalAmount,
//             'status' => 'pending', // Initial status
//         ]);

//         // Clear the cart after order is created
//         Cart::where('user_id', $userId)->delete();

//         \DB::commit();

//         // Log for debugging
//         \Log::info('Order created successfully, redirect URL:', ['url' => route('pos.orders.list')]);

//         // Return success and redirect URL for the orders list page
//         return response()->json([
//             'success' => true,
//             'message' => 'Order created successfully!',
//             'redirect_url' => url('/pos/orders'),  // Ensure it's correct
//         ]);

//     } catch (\Exception $e) {
//         \DB::rollBack();

//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to create order. Please try again!',
//             'error' => $e->getMessage(), // Optional: for debugging
//         ]);
//     }
// }

public function createOrder(Request $request)
{
    $userId = auth()->id();

    // Fetch the cart items for the user
    $cartItems = Cart::where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Your cart is empty!',
        ]);
    }

    \DB::beginTransaction();

    try {
        // Calculate total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->discounted_price ?? $item->price);
        });

        // Create a new order
        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => 'pending', // Initial status
        ]);

        // Clear the cart after order is created
        Cart::where('user_id', $userId)->delete();

        \DB::commit();

        // Return success and redirect URL for the orders list page
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!',
            'redirect_url' => route('pos.orders.list'), // Correct route to the orders list page
        ]);
    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to create order. Please try again!',
            'error' => $e->getMessage(), // Optional: for debugging
        ]);
    }
}








// public function orderConfirmation()
// {
//     $order = Order::with('orderDetails.product')->findOrFail($id);

//     return view('admin.pages.order.confirmation', compact('order'));
// }



// public function orderConfirmation()
// {
//     // Retrieve all orders with their related details and products
//     $orders = Order::with('orderDetails.product')->get();

//     // Pass all orders to the view
//     return view('admin.pages.order.confirmation', compact('orders'));
// }




    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'total_price' => array_sum(array_map(fn($item) => $item['quantity'] * $item['discounted_price'], $cart)),
        ]);

        foreach ($cart as $product_id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product_id,
                'quantity' => $item['quantity'],
                'price' => $item['discounted_price'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('pos.orders.list')->with('success', 'Order placed successfully.');
    }



    public function orderList(Request $request)
    {
        // Start building the query
        $query = Order::with('user', 'orderDetails.product');

        // Check if start_date and end_date are provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date,
            ]);
        }

        // Execute the query and get the orders
        $orders = $query->latest()->get();

        // Return the view with filtered or all orders
        return view('admin.pages.pos.orders', compact('orders'));
    }






}
