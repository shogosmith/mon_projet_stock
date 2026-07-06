<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index() {
        $orders = Order::with(['supplier'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('employee.orders.index', compact('orders'));
    }

    public function create() {
        $products  = Product::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('employee.orders.create', compact('products', 'suppliers'));
    }

    public function store(Request $request) {
        $request->validate([
            'supplier_id'      => 'nullable|exists:suppliers,id',
            'notes'            => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'supplier_id'  => $request->supplier_id,
            'user_id'      => auth()->id(),
            'status'       => 'pending',
            'notes'        => $request->notes,
            'total'        => 0,
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
            $total += $item['quantity'] * $item['unit_price'];
        }

        $order->update(['total' => $total]);

        return redirect()->route('employee.orders.index')
            ->with('success', 'Commande créée avec succès.');
    }

    public function show(Order $order) {
        $order->load(['supplier', 'items.product']);
        return view('employee.orders.show', compact('order'));
    }
}