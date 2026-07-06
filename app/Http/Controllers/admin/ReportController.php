<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    public function index() {
        $total_value = Product::sum(DB::raw('quantity * price'));
        $low_stock   = Product::whereColumn('quantity', '<=', 'alert_quantity')->get();

        // Produits les plus mouvementés (les plus vendus / utilisés)
        $top_movements = StockMovement::with('product')
            ->selectRaw('product_id, count(*) as total, sum(case when type = "out" then quantity else 0 end) as total_sorties')
            ->groupBy('product_id')
            ->orderByDesc('total_sorties')
            ->take(10)
            ->get();

        // Taux de rotation — sorties des 30 derniers jours / stock moyen
        $rotation = Product::with('stockMovements')->get()->map(function ($product) {
            $sorties30j = $product->stockMovements()
                ->where('type', 'out')
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('quantity');

            $rotation_rate = $product->quantity > 0
                ? round($sorties30j / $product->quantity, 2)
                : 0;

            return [
                'product'   => $product,
                'sorties30j' => $sorties30j,
                'rotation'  => $rotation_rate,
            ];
        })->sortByDesc('rotation')->take(10);

        // Prévision de rupture de stock (basé sur la moyenne de sortie quotidienne)
        $previsions = Product::where('is_active', true)->get()->map(function ($product) {
            $sorties30j = $product->stockMovements()
                ->where('type', 'out')
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('quantity');

            $moyenne_jour = $sorties30j > 0 ? $sorties30j / 30 : 0;

            $jours_restants = $moyenne_jour > 0
                ? round($product->quantity / $moyenne_jour)
                : null;

            return [
                'product'         => $product,
                'moyenne_jour'    => round($moyenne_jour, 1),
                'jours_restants'  => $jours_restants,
            ];
        })->filter(function ($item) {
            return $item['jours_restants'] !== null && $item['jours_restants'] <= 30;
        })->sortBy('jours_restants')->take(10);

        // Valeur du stock par mois (6 derniers mois)
   // Valeur du stock par mois (6 derniers mois)
$monthly_value = [];
for ($i = 5; $i >= 0; $i--) {
    $monthDate = now()->subMonths($i);
    $endOfMonth = $monthDate->copy()->endOfMonth();

    $value = StockMovement::where('stock_movements.created_at', '<=', $endOfMonth)
        ->where('type', 'in')
        ->join('products', 'stock_movements.product_id', '=', 'products.id')
        ->sum(DB::raw('stock_movements.quantity * products.price'));

    $monthly_value[] = [
        'month' => $monthDate->format('M Y'),
        'value' => $value,
    ];
}

        return view('admin.reports.index', compact(
            'total_value', 'low_stock', 'top_movements',
            'rotation', 'previsions', 'monthly_value'
        ));
    }

   public function export() {
    $products    = Product::with(['category', 'supplier'])->get();
    $total_value = Product::sum(\DB::raw('quantity * price'));
    $low_stock   = Product::whereColumn('quantity', '<=', 'alert_quantity')->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact(
        'products', 'total_value', 'low_stock'
    ));

    return $pdf->download('rapport-stock-' . now()->format('Y-m-d') . '.pdf');
}
}