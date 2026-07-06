<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_products' => Product::where('is_active', true)->count(),
            'low_stock'      => Product::whereColumn('quantity', '<=', 'alert_quantity')->count(),
            'my_movements'   => StockMovement::where('user_id', auth()->id())->count(),
        ];

        $recent_movements = StockMovement::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = Product::whereColumn('quantity', '<=', 'alert_quantity')
            ->orderBy('quantity')
            ->take(5)
            ->get();

        return view('employee.dashboard', compact('stats', 'recent_movements', 'low_stock_products'));
    }
}