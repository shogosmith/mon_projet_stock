<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;

class NotificationController extends Controller {
    public function index() {
        $low_stock_products = Product::with('category')
            ->whereColumn('quantity', '<=', 'alert_quantity')
            ->orderBy('quantity')
            ->get();

        $out_of_stock = Product::where('quantity', 0)->count();

        $recent_movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(15)
            ->get();

        return view('admin.notifications', compact(
            'low_stock_products',
            'out_of_stock',
            'recent_movements'
        ));
    }
}