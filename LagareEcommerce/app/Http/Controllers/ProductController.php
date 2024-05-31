<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // if (auth()->check()) {
        //     $products = Product::all();
        //     return view('products.index', compact('products'));
        // }

        if (auth()->check()) {
            $user = auth()->user();
            $products = $user->products()->get(); // Fetch products uploaded by the authenticated user
            return view('products.index', compact('products'));
        }
        return view('login');
    }

    public function create()
    {
        return view('products.create');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'quantity' => 'required|integer',
    //         'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    //     ]);

    //     // if ($request->hasFile('image')) {
    //     //     $path = $request->file('image')->store('public/images');
    //     //     $validated['image'] = $path;
    //     // }
    //     if ($request->hasFile('image')) {
    //         $validated['image'] = $request->file('image')->store('images', 'public');
    //     }

    //     Product::create($validated);

    //     return redirect()->route('products.index');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // if ($request->hasFile('image')) {
        //     // Store the image in the public/assets/img directory
        //     $imagePath = $request->file('image')->store('assets/img', 'public');

        //     // Set the image path in the validated data
        //     $validated['image'] = $imagePath;
        // }

        $product = Product::create($validated);

        // Attach the product to the authenticated user
        auth()->user()->products()->attach($product->id);

        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
