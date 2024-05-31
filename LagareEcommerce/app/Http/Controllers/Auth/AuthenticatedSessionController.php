<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     dd('Authenticated and redirecting');

    //     return redirect()->route('products.index');
    //     // $request->authenticate();

    //     // $request->session()->regenerate();

    //     // // Get the authenticated user
    //     // $user = Auth::user();

    //     // // Retrieve the user's role
    //     // $role = $user->roles()->first()->name; // Assuming 'name' is the attribute storing the role name

    //     // $products = Product::all();
    //     // // Redirect the user based on their role
    //     // return redirect()->route('products.index');
    //     // // return redirect()->route('index', ['products' => $products]); // Replace 'user_dashboard' with the route name for the user dashboard


    //     // // switch ($role) {
    //     // //     case 'vendor':
    //     // //         return redirect()->route('products.index'); // Replace 'vendor_dashboard' with the route name for the vendor dashboard
    //     // //         break;
    //     // //     case 'admin':
    //     // //         return redirect()->route('products.index'); // Replace 'admin_dashboard' with the route name for the admin dashboard
    //     // //         break;
    //     // //     default:
    //     // //         // return redirect()->route('products.index');
    //     // //         // return redirect()->route('index', ['products' => $products]); // Replace 'user_dashboard' with the route name for the user dashboard
    //     // //         return view('index', compact('products'));
    //     // //         break;
    //     // // }
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log the authenticated user
        Log::info('User authenticated: ', ['user' => Auth::user()]);

        return redirect()->route('index');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
