<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class StockMovementController extends Controller {
    public function index() {
        $movements = StockMovement::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('employee.movements.index', compact('movements'));
    }

    public function create() {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('employee.movements.create', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out,adjustment',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'nullable|string|max:255',
            'reference'  => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($request->product_id);
        $before  = $product->quantity;

        if ($request->type === 'out' && $request->quantity > $before) {
            return back()->withErrors([
                'quantity' => 'Stock insuffisant. Disponible : ' . $before . ' unités.'
            ])->withInput();
        }

        $after = match($request->type) {
            'in'         => $before + $request->quantity,
            'out'        => $before - $request->quantity,
            'adjustment' => $request->quantity,
        };

        StockMovement::create([
            'product_id'      => $product->id,
            'user_id'         => auth()->id(),
            'type'            => $request->type,
            'quantity'        => $request->quantity,
            'quantity_before' => $before,
            'quantity_after'  => $after,
            'reason'          => $request->reason,
            'reference'       => $request->reference,
        ]);

        $product->update(['quantity' => $after]);

        return redirect()->route('employee.movements.index')
            ->with('success', 'Mouvement enregistré avec succès.');
    }
}