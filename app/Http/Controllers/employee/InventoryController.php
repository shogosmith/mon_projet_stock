<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller {
    public function index() {
        $inventories = Inventory::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('employee.inventories.index', compact('inventories'));
    }

    public function create() {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('employee.inventories.create', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'notes'                        => 'nullable|string',
            'items'                        => 'required|array|min:1',
            'items.*.product_id'           => 'required|exists:products,id',
            'items.*.physical_quantity'    => 'required|integer|min:0',
        ]);

        $inventory = Inventory::create([
            'reference' => 'INV-' . strtoupper(uniqid()),
            'user_id'   => auth()->id(),
            'status'    => 'completed',
            'notes'     => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $diff    = $item['physical_quantity'] - $product->quantity;

            InventoryItem::create([
                'inventory_id'         => $inventory->id,
                'product_id'           => $product->id,
                'theoretical_quantity' => $product->quantity,
                'physical_quantity'    => $item['physical_quantity'],
                'difference'           => $diff,
            ]);
        }

        return redirect()->route('employee.inventories.index')
            ->with('success', 'Inventaire enregistré avec succès.');
    }

    public function show(Inventory $inventory) {
        $inventory->load(['items.product', 'user']);
        return view('employee.inventories.show', compact('inventory'));
    }
}