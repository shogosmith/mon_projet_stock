<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::with(['category', 'supplier'])
            ->where('is_active', true);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('reference', 'like', "%{$request->search}%");
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('employee.products.index', compact('products', 'categories'));
    }

    public function show(Product $product) {
        $product->load(['category', 'supplier']);
        return view('employee.products.show', compact('product'));
    }
}