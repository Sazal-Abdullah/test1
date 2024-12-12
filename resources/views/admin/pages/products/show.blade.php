@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Product Details</h3>
                </div>
                <div class="card-body">
                    <h2>{{ $product->name }}</h2>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 200px;">
                    <p>SKU: {{ $product->sku }}</p>
                    <p>Unit: {{ $product->unit }} ({{ $product->unit_value }})</p>
                    <p>Selling Price: {{ $product->selling_price }}</p>
                    <p>Purchase Price: {{ $product->purchase_price }}</p>
                    <p>Discount: {{ $product->discount }}%</p>
                    <p>Tax: {{ $product->tax }}%</p>

                    <h4>Variations</h4>
                    <ul>
                        @foreach ($product->variations as $variation)
                            <li>{{ $variation->variation_name }}: {{ $variation->variation_value }} ({{ $variation->selling_price }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
