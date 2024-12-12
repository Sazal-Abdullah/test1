@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"> order</h3>
                </div>
                <div class="card-body">
                    <div class="container mt-5">
                        <h2>Order Confirmation</h2>
                        {{-- <p>Thank you for your order! Your order ID is {{ $order->id }}.</p> --}}
                        <h4>Order Summary:</h4>
                        <ul>
                            @foreach ($order->orderDetails as $detail)
                                <li>
                                    {{ $detail->product->name }} - {{ $detail->quantity }} x ${{ $detail->discounted_price }}
                                    = ${{ $detail->total_price }}
                                </li>
                            @endforeach
                        </ul>
                        <h5>Total: ${{ $order->total_amount }}</h5>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
