<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;

class StockMovementController extends Controller {
    public function index() {
        $movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->paginate(20);
        return view('admin.movements.index', compact('movements'));
    }
}