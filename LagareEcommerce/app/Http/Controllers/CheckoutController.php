<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('checkout.index', compact('cartItems'));
    }

    public function process(Request $request)
    {
        // Validate request data

        // Calculate total price of the order
        $totalPrice = 0;
        foreach ($request->cart_items as $cartItem) {
            $product = Product::findOrFail($cartItem['product_id']);
            $totalPrice += $product->price * $cartItem['quantity'];
        }

        // Create a new order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_price = $totalPrice; // Set the total price
        $order->save();

        // Update stock levels for each product in the cart
        foreach ($request->cart_items as $cartItem) {
            $product = Product::findOrFail($cartItem['product_id']);
            $product->quantity -= $cartItem['quantity'];
            $product->save();
        }

        // Clear the user's cart
        Cart::where('user_id', Auth::id())->delete();

        // Redirect to a thank you page or order summary
        return redirect()->route('order.summary', $order->id);
    }
}
