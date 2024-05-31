<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {

        // if (auth()->check()) {
        //     $user = auth()->user();
        //     if (!$user->hasRole('admin') && !$user->hasRole('vendor')) {
        //         $products = Product::all();
        //     } else {
        //         $products = $user->products()->get();
        //     }
        // }
        $products = Product::all();
        return view('index', compact('products'));
    }
}
