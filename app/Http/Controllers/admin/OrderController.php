<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller {
    public function index() {
        $orders = Order::with(['supplier', 'user'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load(['supplier', 'user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|in:pending,approved,received,cancelled'
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function exportPdf(Order $order) {
        $order->load(['supplier', 'user', 'items.product']);
        $pdf = Pdf::loadView('admin.orders.pdf', compact('order'));
        return $pdf->download('commande-' . $order->order_number . '.pdf');
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée.');
    }
}