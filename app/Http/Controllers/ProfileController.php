<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function index()
    {
        try {
            // withoutVerifying() prevents local Windows/Laragon SSL cURL errors
            $newsResponse = Http::withoutVerifying()
                ->timeout(5)
                ->get('https://api.rss2json.com/v1/api.json?rss_url=https://www.theverge.com/rss/index.xml');

            $articles = $newsResponse->successful()
                ? collect($newsResponse->json()['items'] ?? [])->take(3)
                : collect();
        } catch (\Exception $e) {
            $articles = collect();
        }

        $products = \App\Models\Product::with(['category', 'brand'])->get();

        $stats = [
            'products_count'     => \App\Models\Product::count(),
            'categories_count'   => \App\Models\Category::count(),
            'brands_count'       => \App\Models\Brand::count(),
            'orders_count'       => \App\Models\Order::count(),
            'out_of_stock_count' => \App\Models\Product::where('stock', '<=', 0)->count(),
        ];

        return view('dashboard', compact('articles', 'products', 'stats'));
    }
}
