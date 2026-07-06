<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::with(['category', 'supplier']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('reference', 'like', "%{$request->search}%");
            });
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->status === 'low') {
            $query->whereColumn('quantity', '<=', 'alert_quantity');
        }

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create() {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'suppliers'  => Supplier::all(),
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'reference'      => 'required|string|unique:products',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
            'category_id'    => 'nullable|exists:categories,id',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
    }

    public function show(Product $product) {
        $product->load(['category', 'supplier', 'stockMovements.user']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product) {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => Category::all(),
            'suppliers'  => Supplier::all(),
        ]);
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'reference'      => 'required|string|unique:products,reference,' . $product->id,
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
            'category_id'    => 'nullable|exists:categories,id',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    // SUPPRESSION — Admin seulement
    public function destroy(Product $product) {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
}