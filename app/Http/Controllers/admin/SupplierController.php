<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller {
    public function index() {
        $suppliers = Supplier::withCount('products')->latest()->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create() {
        return view('admin.suppliers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
        ]);
        Supplier::create($request->only('name', 'email', 'phone', 'address', 'country'));
        return redirect()->route('admin.suppliers.index')->with('success', 'Fournisseur créé.');
    }

    public function show(Supplier $supplier) {
        $supplier->load('products', 'orders');
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier) {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
        ]);
        $supplier->update($request->only('name', 'email', 'phone', 'address', 'country'));
        return redirect()->route('admin.suppliers.index')->with('success', 'Fournisseur mis à jour.');
    }

    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Fournisseur supprimé.');
    }
}