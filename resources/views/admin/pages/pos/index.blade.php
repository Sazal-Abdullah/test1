@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <!-- Left: Product List -->
                        <div class="col-lg-8">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0">Product List</h3>
                            </div>
                            <form method="GET" action="{{ route('pos.index') }}" class="mb-3 mt-1">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name or SKU" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4"> <!-- Adjust the column size based on screen size -->
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="
                                                object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                                                <p class="card-text mb-1 text-muted">SKU: {{ $product->sku }}</p>
                                                <p class="card-text mb-0 text-success fw-bold">Price: ${{ $product->selling_price }}</p>
                                                <p class="card-text mb-0 text-muted">Discount: {{ $product->discount }}%</p>
                                                <p class="card-text text-danger">Discounted Price: ${{ number_format($product->selling_price - ($product->selling_price * $product->discount / 100), 2) }}</p>
                                                <button class="btn btn-primary add-to-cart"
                                                        data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-price="{{ $product->selling_price }}"
                                                        data-discount="{{ $product->discount }}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{ $products->links() }}
                        </div>

                        <!-- Right: Shopping Cart -->
                        <div class="col-lg-4">
                            <div class="card-header bg-success text-white">
                                <h3 class="mb-0">Shopping Cart</h3>
                            </div>
                            <div id="cart" class="card shadow-sm p-3">
                                <div class="cart-items" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 20%;">Image</th>
                                                <th style="width: 40%;">Name</th>
                                                <th style="width: 15%;">Qty</th>
                                                <th style="width: 15%;">Price</th>
                                                <th style="width: 10%;">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-table-body">
                                            @foreach($cartItems as $item)
                                                <tr data-id="{{ $item->id }}">
                                                    <td>
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->name }}" style="width: 50px; height: auto;">
                                                        @else
                                                            <span>No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm update-qty"
                                                               data-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1">
                                                    </td>
                                                    <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-danger remove-item" data-id="{{ $item->id }}">&times;</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart-footer mt-3">
                                    <h5 class="d-flex justify-content-between">
                                        <span>Total:</span>
                                        <span id="cart-total" class="text-success">
                                            ${{ number_format($cartItems->sum('total_price'), 2) }}
                                        </span>
                                    </h5>
                                    <button class="btn btn-primary btn-block mt-3" id="checkout-btn" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>
                                        Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;
            const productName = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const discount = parseFloat(this.dataset.discount);

            const discountedPrice = price - (price * discount / 100);
            const quantity = 1; // Default quantity

            // Ajax request for adding to cart
            fetch('{{ route("pos.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    product_id: productId,
                    name: productName,
                    price: price,
                    discounted_price: discountedPrice,
                    quantity: quantity,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTable(data.cart); // Update the cart UI
                } else {
                    console.error('Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });


    // Function to dynamically update the cart table
    function updateCartTable(cart) {
        const cartTableBody = document.getElementById('cart-table-body');
        cartTableBody.innerHTML = ''; // Clear current cart items

        let total = 0;

        cart.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <img src="/storage/${item.product.image}" alt="${item.name}" style="width: 50px; height: auto;">
                </td>
                <td>${item.name}</td>
                <td>
                    <input type="number" class="form-control form-control-sm update-qty"
                           data-id="${item.id}" value="${item.quantity}" min="1">
                </td>
                <td class="text-right">$${(item.quantity * item.discounted_price).toFixed(2)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger remove-item" data-id="${item.id}">&times;</button>
                </td>
            `;
            cartTableBody.appendChild(row);

            total += item.quantity * item.discounted_price;
        });

        // Update total price
        document.getElementById('cart-total').innerText = `$${total.toFixed(2)}`;

        // Enable checkout button if cart is not empty
        document.getElementById('checkout-btn').disabled = cart.length === 0;
    }
</script>

<script>
    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('update-qty')) {
            const cartId = event.target.dataset.id;
            const newQuantity = parseInt(event.target.value);

            if (newQuantity < 1) {
                alert('Quantity must be at least 1.');
                return;
            }

            // Send AJAX request to update quantity
            fetch('{{ route("pos.cart.updateQuantity") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: newQuantity,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTable(data.cart); // Update the cart table dynamically
                } else {
                    console.error('Failed to update cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>

<script>
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-item')) {
            const cartId = event.target.dataset.id;

            // Confirm removal
            if (!confirm('Are you sure you want to remove this item from the cart?')) {
                return;
            }

            // Send AJAX request to remove the item
            fetch('{{ route("pos.cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ cart_id: cartId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTable(data.cart); // Update the cart table dynamically
                } else {
                    console.error('Failed to remove cart item.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>



<script>

    document.getElementById('checkout-btn').addEventListener('click', function () {
        // Send AJAX request to create an order
        fetch('{{ route("pos.order.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success alert
                alert('Order created successfully!');

                // Clear cart UI
                document.getElementById('cart-items-container').innerHTML = '<p>Your cart is now empty.</p>';

                // Redirect to the orders page
                window.location.href = data.redirect_url; // This will take the user to the order list page
            } else {
                // Handle failure silently
                console.error('Failed to create order:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>




@endsection
