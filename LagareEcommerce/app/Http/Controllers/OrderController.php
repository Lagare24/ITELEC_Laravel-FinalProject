<?php

// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders;
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_price = 0; // This will be calculated below
        $order->save();

        $totalPrice = 0;

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price * $quantity;

            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $totalPrice += $price;

            // Reduce product stock
            $product->quantity -= $quantity;
            $product->save();
        }

        $order->total_price = $totalPrice;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully');
    }
    public function summary($id)
    {
        $order = Order::findOrFail($id);
        // $products = $order[0]->
        return view('orders.summary', compact('order'));
    }
}
