@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Product Name & SKU -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sku">Product SKU</label>
                                    <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Unit & Unit Value -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <input type="text" name="unit" id="unit" class="form-control" value="{{ $product->unit }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_value">Unit Value</label>
                                    <input type="text" name="unit_value" id="unit_value" class="form-control" value="{{ $product->unit_value }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Selling Price & Purchase Price -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="number" name="selling_price" id="selling_price" class="form-control" value="{{ $product->selling_price }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="number" name="purchase_price" id="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Discount & Tax -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount">Discount (%)</label>
                                    <input type="number" name="discount" id="discount" class="form-control" value="{{ $product->discount }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax">Tax (%)</label>
                                    <input type="number" name="tax" id="tax" class="form-control" value="{{ $product->tax }}">
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <br>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px;">
                            @endif
                        </div>

                        <!-- Product Variations -->
                        <h4>Product Variations</h4>
                        <div id="variations">
                            @foreach($product->variations as $index => $variation)
                                <div class="variation">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="variation_name">Variation Name</label>
                                                <input type="text" name="variations[{{ $index }}][name]" class="form-control" value="{{ $variation->name }}" placeholder="e.g. Color, Size, Weight">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="variation_value">Variation Value</label>
                                                <input type="text" name="variations[{{ $index }}][value]" class="form-control" value="{{ $variation->value }}" placeholder="e.g. Red, XL, 1KG">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="variation_purchase_price">Variation Purchase Price</label>
                                                <input type="number" name="variations[{{ $index }}][purchase_price]" class="form-control" value="{{ $variation->purchase_price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="variation_selling_price">Variation Selling Price</label>
                                                <input type="number" name="variations[{{ $index }}][selling_price]" class="form-control" value="{{ $variation->selling_price }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
