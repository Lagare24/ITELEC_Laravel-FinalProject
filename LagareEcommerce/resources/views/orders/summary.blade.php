@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Summary</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Total Price: ${{ $order->total_price }}</p>
        <h3>Order Items:</h3>
        <ul>
            @foreach($order->products as $product)
                <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }} - Price: ${{ $product->pivot->price }}</li>
            @endforeach
        </ul>
    </div>
@endsection
