<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\StockMovement;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_products'  => Product::count(),
            'low_stock'       => Product::whereColumn('quantity', '<=', 'alert_quantity')->count(),
            'total_employees' => User::where('role', 'employee')->count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'total_value'     => Product::sum(DB::raw('quantity * price')),
        ];

        $recent_movements = StockMovement::with(['product', 'user'])
            ->latest()->take(10)->get();

        $low_stock_products = Product::with('category')
            ->whereColumn('quantity', '<=', 'alert_quantity')
            ->orderBy('quantity')->take(8)->get();

        // Graphique mouvements 7 derniers jours
        $movements_chart = StockMovement::selectRaw('DATE(created_at) as date, type, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get();

        $chart_labels = [];
        $chart_in = [];
        $chart_out = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $chart_labels[] = $label;
            $in = $movements_chart->where('date', $date)->where('type', 'in')->first();
            $out = $movements_chart->where('date', $date)->where('type', 'out')->first();
            $chart_in[] = $in ? $in->total : 0;
            $chart_out[] = $out ? $out->total : 0;
        }

        // Graphique stock par catégorie
        $categories_chart = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->get();

        // Graphique valeur par catégorie
        $value_chart = Category::join('products', 'categories.id', '=', 'products.category_id')
            ->selectRaw('categories.name, SUM(products.quantity * products.price) as total_value')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recent_movements', 'low_stock_products',
            'chart_labels', 'chart_in', 'chart_out',
            'categories_chart', 'value_chart'
        ));
    }
}