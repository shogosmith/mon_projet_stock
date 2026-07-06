<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockMovementController as AdminMovement;
use App\Http\Controllers\Employee\DashboardController as EmpDashboard;
use App\Http\Controllers\Employee\StockMovementController as EmpMovement;
use App\Http\Controllers\Employee\ProductController as EmpProduct;
use App\Http\Controllers\Employee\OrderController as EmpOrder;
use App\Http\Controllers\Employee\ProfileController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\InvoiceController;


// Page d'accueil → redirige vers login
Route::get('/', fn() => redirect()->route('login'));

// Redirection après login selon le rôle
Route::get('/home', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware('auth')->name('home');

// ============ ESPACE ADMIN ============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search');
    Route::get('/inventories', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventories.index');
    Route::get('/inventories/{inventory}', [\App\Http\Controllers\Admin\InventoryController::class, 'show'])->name('inventories.show');

    // Historique des connexions
    Route::get('/login-histories', [\App\Http\Controllers\Admin\LoginHistoryController::class, 'index'])->name('login_histories.index');
    Route::delete('/login-histories/clear-old', [\App\Http\Controllers\Admin\LoginHistoryController::class, 'clearOld'])->name('login_histories.clear_old');
    Route::delete('/login-histories/clear', [\App\Http\Controllers\Admin\LoginHistoryController::class, 'clear'])->name('login_histories.clear');

    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [\App\Http\Controllers\Admin\CompanySettingController::class, 'index'])->name('settings');
    Route::put('/settings', [\App\Http\Controllers\Admin\CompanySettingController::class, 'update'])->name('settings.update');

    // Clients
    Route::resource('clients', ClientController::class);

    // Factures
    Route::resource('invoices', InvoiceController::class);
    Route::patch('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.status');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'exportPdf'])->name('invoices.pdf');

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Produits (CRUD complet avec suppression)
    Route::resource('products', AdminProduct::class);

    // Catégories
    Route::resource('categories', CategoryController::class);

    // Fournisseurs
    Route::resource('suppliers', SupplierController::class);

    // Employés
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::get('/inventories', [\App\Http\Controllers\Employee\InventoryController::class, 'index'])->name('inventories.index');

    // Commandes
    Route::resource('orders', AdminOrder::class);
    Route::patch('orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.status');
    Route::get('orders/{order}/pdf', [\App\Http\Controllers\Admin\OrderController::class, 'exportPdf'])->name('orders.pdf');

    // Mouvements de stock
    Route::get('/movements', [AdminMovement::class, 'index'])->name('movements.index');

    // Rapports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// ============ ESPACE EMPLOYÉ ============
Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function () {
    Route::get('/inventories', [\App\Http\Controllers\Employee\InventoryController::class, 'index'])->name('inventories.index');
    Route::get('/inventories/create', [\App\Http\Controllers\Employee\InventoryController::class, 'create'])->name('inventories.create');
    Route::post('/inventories', [\App\Http\Controllers\Employee\InventoryController::class, 'store'])->name('inventories.store');
    Route::get('/inventories/{inventory}', [\App\Http\Controllers\Employee\InventoryController::class, 'show'])->name('inventories.show');

    // Dashboard
    Route::get('/dashboard', [EmpDashboard::class, 'index'])->name('dashboard');

    // Produits (lecture seule — pas de suppression)
    Route::get('/products', [EmpProduct::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [EmpProduct::class, 'show'])->name('products.show');

    // Mouvements de stock
    Route::get('/movements', [EmpMovement::class, 'index'])->name('movements.index');
    Route::get('/movements/create', [EmpMovement::class, 'create'])->name('movements.create');
    Route::post('/movements', [EmpMovement::class, 'store'])->name('movements.store');

    // Commandes (créer et voir — pas supprimer)
    Route::get('/orders', [EmpOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [EmpOrder::class, 'create'])->name('orders.create');
    Route::post('/orders', [EmpOrder::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [EmpOrder::class, 'show'])->name('orders.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes auth de Breeze
require __DIR__.'/auth.php';