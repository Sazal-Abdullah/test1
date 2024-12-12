@extends('frontend.layouts.master')

@section('content')

<main class="container my-5">

    <!-- Hero Section -->
    <section id="hero" class="text-center py-5" style="background-color: #f8f9fa; border-radius: 8px;">
        <h1 class="display-4 text-primary">Welcome to My Laravel App</h1>
        <p class="lead">Your one-stop solution for all your needs.</p>
        <a href="#services" class="btn btn-primary btn-lg">Explore Services</a>
    </section>

    <!-- About Us Section -->
    <section id="about" class="my-5">
        <h2 class="text-center text-primary mb-4">About Us</h2>
        <p class="text-center">We are a team of professionals providing excellent services to our customers. Our mission is to bring you the best solutions and products tailored to your needs. Join us on this journey towards excellence.</p>
    </section>

    <!-- Services Section -->
    <section id="services" class="my-5">
        <h2 class="text-center text-primary mb-4">Our Services</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Service 1">
                    <div class="card-body">
                        <h5 class="card-title">Service 1</h5>
                        <p class="card-text">Description of Service 1. We offer high-quality products and excellent customer support.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Service 2">
                    <div class="card-body">
                        <h5 class="card-title">Service 2</h5>
                        <p class="card-text">Description of Service 2. Our expertise ensures your satisfaction with every purchase.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Service 3">
                    <div class="card-body">
                        <h5 class="card-title">Service 3</h5>
                        <p class="card-text">Description of Service 3. We are committed to providing the best service with a smile.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section id="products" class="my-5">
        <h2 class="text-center text-primary mb-4">Our Products</h2>
        <!-- Products Grid -->
        <div class="row g-4">
            @forelse ($products as $product)
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <!-- Product Image -->
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 400px;">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-3 py-2">-{{ $product->discount }}%</span>
                    </div>
                    <!-- Product Details -->
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                        <p class="mb-1"><strong>SKU:</strong> {{ $product->sku }}</p>
                        <p class="mb-1"><strong>Price:</strong> <del>${{ number_format($product->selling_price, 2) }}</del></p>
                        <p class="text-success fw-bold"><strong>Discount Price:</strong> ${{ number_format($product->selling_price - ($product->selling_price * $product->discount / 100), 2) }}</p>
                        <!-- Add to Cart Button -->
                        <div class="d-grid">
                            <a href="#" class="btn btn-success btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">No products found.</p>
            </div>
            @endforelse
        </div>
    </section>


    <!-- Contact Us Section -->
    <section id="contact" class="my-5">
        <h2 class="text-center text-primary mb-4">Contact Us</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Your Name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Your Email">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </section>
</main>

@endsection
