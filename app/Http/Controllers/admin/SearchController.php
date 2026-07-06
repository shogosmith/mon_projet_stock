<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function index(Request $request) {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return view('admin.search', ['query' => $query, 'results' => []]);
        }

        $products = Product::with(['category', 'supplier'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('reference', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(8)->get();

        $suppliers = Supplier::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->take(5)->get();

        $orders = Order::with(['supplier', 'user'])
            ->where('order_number', 'like', "%{$query}%")
            ->orWhereHas('supplier', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->take(5)->get();

        $users = User::where('role', 'employee')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })->take(5)->get();

        $total = $products->count() + $suppliers->count() + $orders->count() + $users->count();

        return view('admin.search', compact('query', 'products', 'suppliers', 'orders', 'users', 'total'));
    }
}