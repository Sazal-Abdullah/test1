@extends('frontend.layouts.master')

@section('content')

<main class="container my-5">

    <!-- Hero Section -->
    {{-- <section id="hero" class="text-center py-5 mb-5" style="background: linear-gradient(90deg, #4facfe, #00f2fe); color: white; border-radius: 12px;">
        <img src="{{ asset('frontend/them.jpg')}}" alt="">
        <h1 class="display-4 fw-bold">Welcome to My Laravel App</h1>
        <p class="lead">Your one-stop solution for all your needs.</p>
        <a href="#services" class="btn btn-light btn-lg shadow">Explore Services</a>
    </section> --}}
    <!-- Hero Section -->
{{-- <section id="hero" class="text-center py-5 mb-5"
style="background: url('{{ asset('frontend/them.jpg') }}') no-repeat center center/cover; color: white; border-radius: 12px;">
<div class="container">
    <h1 class="display-4 fw-bold">Welcome to My Laravel App</h1>
    <p class="lead">Your one-stop solution for all your needs.</p>
    <a href="#services" class="btn btn-light btn-lg shadow">Explore Services</a>
</div>
</section> --}}

<!-- Hero Section -->
<section id="hero" class="text-center py-5 mb-5 position-relative"
    style="background: url('{{ asset('frontend/them.jpg') }}') no-repeat center center/cover; color: white; border-radius: 12px; overflow: hidden;">
    <div class="hero-overlay"
        style="position: absolute; top: 0; left: 0; height: 700px; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); border-radius: 12px;">
    </div>
    <div class="container position-relative" style="z-index: 1; margin-top: 340px;">
        <h1 class="display-4 fw-bold">Welcome to My Laravel App please Login</h1>
        <p class="lead">Your one-stop solution for all your needs.</p>
        <a href="#services" class="btn btn-light btn-lg shadow">Explore Services</a>
    </div>
</section>



    <!-- About Us Section -->
    {{-- <section id="about" class="my-5">
        <h2 class="text-center text-primary mb-4">About Us</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="text-center">We are a team of professionals providing excellent services to our customers. Our mission is to bring you the best solutions and products tailored to your needs. Join us on this journey towards excellence.</p>
            </div>
        </div>
    </section> --}}
    {{-- <section id="about" class="my-5">
        <h2 class="text-center text-primary mb-4">About Me</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="lead">I am <strong>Sazal Abdullah</strong>, a passionate <strong>Full Stack Developer</strong> specializing in <strong>PHP</strong> and <strong>Laravel</strong>.</p>
                <p>With a commitment to delivering high-quality, tailored solutions, I strive to help businesses achieve their goals through efficient and scalable web applications. Let's work together to turn your ideas into reality!</p>
            </div>
        </div>
    </section> --}}
    <section id="about" class="my-5">
        <h2 class="text-center text-primary mb-4">About Me</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p>Hello I am <strong>Sazal Abdullah</strong>, a Full Stack Developer specializing in PHP and Laravel. I am passionate about building robust web applications and delivering excellent user experiences. Let's collaborate and create something amazing together!</p>
                <div class="mt-4">
                    <a href="https://drive.google.com/file/d/1DVaAql_WkbPAi1wtFy0SHfCX9rk-nBm0/view" target="_blank" class="btn btn-primary btn-lg mx-2" target="_blank">
                        <i class="fas fa-file-download"></i> View CV
                    </a>
                    <a href="https://sazal-portfolio.netlify.app" class="btn btn-secondary btn-lg mx-2" target="_blank">
                        <i class="fas fa-globe"></i> View Portfolio
                    </a>
                </div>
            </div>
        </div>
    </section>



    <!-- Product Section -->
    <section id="products" class="my-5">
        <h2 class="text-center text-primary mb-4">Our Products</h2>
        <div class="row g-4">
            @forelse ($products as $product)
            <div class="col-md-3">
                <div class="card border-0 shadow">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 300px;  border-radius: 12px;">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-3 py-2">-{{ $product->discount }}%</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                        <p><strong>SKU:</strong> {{ $product->sku }}</p>
                        <p><strong>Price:</strong> <del>${{ number_format($product->selling_price, 2) }}</del></p>
                        <p class="text-success fw-bold"><strong>Discount Price:</strong> ${{ number_format($product->selling_price - ($product->selling_price * $product->discount / 100), 2) }}</p>
                        {{-- <a href="#" class="btn btn-success w-100">Add to Cart</a> --}}
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

    <!-- Services Section -->
    {{-- <section id="services" class="my-5">
        <h2 class="text-center text-primary mb-4">Our Services</h2>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <img src="https://via.placeholder.com/300" class="card-img-top rounded-top" alt="Service 1">
                    <div class="card-body">
                        <h5 class="card-title">Restaurant Website Development</h5>
                        <p class="card-text">Description of Service 1. We offer high-quality products and excellent customer support.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <img src="https://via.placeholder.com/300" class="card-img-top rounded-top" alt="Service 2">
                    <div class="card-body">
                        <h5 class="card-title">Service 2</h5>
                        <p class="card-text">Description of Service 2. Our expertise ensures your satisfaction with every purchase.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <img src="https://via.placeholder.com/300" class="card-img-top rounded-top" alt="Service 3">
                    <div class="card-body">
                        <h5 class="card-title">Service 3</h5>
                        <p class="card-text">Description of Service 3. We are committed to providing the best service with a smile.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section id="services" class="my-5">
        <h2 class="text-center text-primary mb-4">Our Services</h2>
        <div class="row text-center g-4">
            <!-- Service 1: Web Design -->
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Web Design</h5>
                        <p class="card-text">Beautiful and elegant designs with interfaces that are intuitive, efficient, and pleasant to use for the user.</p>
                    </div>
                </div>
            </div>
            <!-- Service 2: Development -->
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <i class="fas fa-code fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Development</h5>
                        <p class="card-text">Custom web development tailored to your specifications, designed to provide user experience.</p>
                    </div>
                </div>
            </div>
            <!-- Service 3: Mobile App -->
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Mobile App</h5>
                        <p class="card-text">Design and transform website projects into mobile apps to provide a seamless user experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- Contact Us Section -->
    <section id="contact" class="my-5">
        <h2 class="text-center text-primary mb-4">Contact Us</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection
