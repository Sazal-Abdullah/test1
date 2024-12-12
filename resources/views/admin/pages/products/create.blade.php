@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Create New Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name & SKU -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sku" class="form-label">Product SKU</label>
                                <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter product SKU" required>
                            </div>
                        </div>

                        <!-- Unit & Unit Value -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" name="unit" id="unit" class="form-control" placeholder="e.g., kg, pcs" required>
                            </div>
                            <div class="col-md-6">
                                <label for="unit_value" class="form-label">Unit Value</label>
                                <input type="text" name="unit_value" id="unit_value" class="form-control" placeholder="e.g., 1, 10" required>
                            </div>
                        </div>

                        <!-- Selling Price & Purchase Price -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="selling_price" class="form-label">Selling Price</label>
                                <input type="number" name="selling_price" id="selling_price" class="form-control" placeholder="Enter selling price" required>
                            </div>
                            <div class="col-md-6">
                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                <input type="number" name="purchase_price" id="purchase_price" class="form-control" placeholder="Enter purchase price" required>
                            </div>
                        </div>

                        <!-- Discount & Tax -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount" class="form-label">Discount (%)</label>
                                <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount percentage">
                            </div>
                            <div class="col-md-6">
                                <label for="tax" class="form-label">Tax (%)</label>
                                <input type="number" name="tax" id="tax" class="form-control" placeholder="Enter tax percentage">
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <!-- Product Variations -->
                        <h4 class="my-3">Product Variations</h4>
                        <div id="variations">
                            <div class="border p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Variation Name</label>
                                        <input type="text" name="variations[0][name]" class="form-control" placeholder="e.g., Color, Size">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Variation Value</label>
                                        <input type="text" name="variations[0][value]" class="form-control" placeholder="e.g., Red, XL">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Variation Purchase Price</label>
                                        <input type="number" name="variations[0][purchase_price]" class="form-control" placeholder="Enter variation purchase price">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Variation Selling Price</label>
                                        <input type="number" name="variations[0][selling_price]" class="form-control" placeholder="Enter variation selling price">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



{{-- @extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Create New Product</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Name & SKU -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sku" class="form-label">Product SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control" placeholder="Enter product SKU" required>
                    </div>
                </div>

                <!-- Unit & Unit Value -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" name="unit" id="unit" class="form-control" placeholder="e.g., kg, pcs" required>
                    </div>
                    <div class="col-md-6">
                        <label for="unit_value" class="form-label">Unit Value</label>
                        <input type="text" name="unit_value" id="unit_value" class="form-control" placeholder="e.g., 1, 10" required>
                    </div>
                </div>

                <!-- Selling Price & Purchase Price -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="selling_price" class="form-label">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" placeholder="Enter selling price" required>
                    </div>
                    <div class="col-md-6">
                        <label for="purchase_price" class="form-label">Purchase Price</label>
                        <input type="number" name="purchase_price" id="purchase_price" class="form-control" placeholder="Enter purchase price" required>
                    </div>
                </div>

                <!-- Discount & Tax -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount percentage">
                    </div>
                    <div class="col-md-6">
                        <label for="tax" class="form-label">Tax (%)</label>
                        <input type="number" name="tax" id="tax" class="form-control" placeholder="Enter tax percentage">
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <!-- Product Variations -->
                <h4 class="my-3">Product Variations</h4>
                <div id="variations">
                    <div class="border p-3 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Variation Name</label>
                                <input type="text" name="variations[0][name]" class="form-control" placeholder="e.g., Color, Size">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Variation Value</label>
                                <input type="text" name="variations[0][value]" class="form-control" placeholder="e.g., Red, XL">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Variation Purchase Price</label>
                                <input type="number" name="variations[0][purchase_price]" class="form-control" placeholder="Enter variation purchase price">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Variation Selling Price</label>
                                <input type="number" name="variations[0][selling_price]" class="form-control" placeholder="Enter variation selling price">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Save Product</button>
            </form>
        </div>
    </div>
</div>
@endsection --}}
