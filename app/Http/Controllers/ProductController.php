<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->get();
        $products = Product::with('variations')->get();
        return view('admin.pages.products.index', compact('products','cartItems'));
    }


    public function create()
    {
        return view('admin.pages.products.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'unit' => 'required|string',
            'unit_value' => 'required|string',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::create($request->except('image'));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->update(['image' => $imagePath]);
        }

        // Store variations (if any)
        if ($request->has('variations')) {
            foreach ($request->variations as $variation) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'variation_name' => $variation['name'],
                    'variation_value' => $variation['value'],
                    'purchase_price' => $variation['purchase_price'],
                    'selling_price' => $variation['selling_price'],
                ]);
            }
        }

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = Product::with('variations')->findOrFail($id);
        return view('admin.pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'unit' => 'required|string',
            'unit_value' => 'required|string',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product->update($request->except('image'));

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->update(['image' => $imagePath]);
        }

        // Update variations
        if ($request->has('variations')) {
            foreach ($request->variations as $variation) {
                // Skip invalid variations
                if (empty($variation['name']) || empty($variation['value']) || empty($variation['purchase_price']) || empty($variation['selling_price'])) {
                    continue;
                }

                if (isset($variation['id'])) {
                    // Update existing variation
                    ProductVariation::where('id', $variation['id'])->update([
                        'variation_name' => $variation['name'],
                        'variation_value' => $variation['value'],
                        'purchase_price' => $variation['purchase_price'],
                        'selling_price' => $variation['selling_price'],
                    ]);
                } else {
                    // Create new variation
                    ProductVariation::create([
                        'product_id' => $product->id,
                        'variation_name' => $variation['name'],
                        'variation_value' => $variation['value'],
                        'purchase_price' => $variation['purchase_price'],
                        'selling_price' => $variation['selling_price'],
                    ]);
                }
            }
        }



        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::with('variations')->findOrFail($id);
        return view('admin.pages.products.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->variations()->delete();
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index');
    }
}
