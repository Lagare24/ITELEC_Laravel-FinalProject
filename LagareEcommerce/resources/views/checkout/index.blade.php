@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Checkout</h1>
        <div class="row">
            <div class="col-md-8">
                <!-- Display cart items -->
                <h3>Your Cart Items</h3>
                <ul>
                    @foreach($cartItems as $item)
                        <li>{{ $item->product->name }} - {{ $item->quantity }}</li>
                    @endforeach
                </ul>
                <!-- Checkout form -->
                <form action="{{ route('checkout.process') }}" method="post">
                    @csrf
                    <!-- Add hidden input fields for each cart item -->
                    @foreach($cartItems as $item)
                        <input type="hidden" name="cart_items[{{ $loop->index }}][product_id]" value="{{ $item->product->id }}">
                        <input type="hidden" name="cart_items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                    @endforeach
                    <!-- Add shipping address fields here -->
                    <!-- Add payment method selection here -->
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
