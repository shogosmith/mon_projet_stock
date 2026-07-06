<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller {
    public function index() {
        $invoices = Invoice::with(['client', 'user'])->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create() {
        $clients  = Client::orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.invoices.create', compact('clients', 'products'));
    }

    public function store(Request $request) {
        $request->validate([
            'client_id'                  => 'nullable|exists:clients,id',
            'due_date'                   => 'nullable|date',
            'tax'                        => 'nullable|numeric|min:0|max:100',
            'notes'                      => 'nullable|string',
            'items'                      => 'required|array|min:1',
            'items.*.product_id'         => 'required|exists:products,id',
            'items.*.quantity'           => 'required|integer|min:1',
            'items.*.unit_price'         => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $taxAmount = $subtotal * ($request->tax ?? 0) / 100;
        $total     = $subtotal + $taxAmount;

        $invoice = Invoice::create([
            'invoice_number' => 'FAC-' . strtoupper(uniqid()),
            'client_id'      => $request->client_id,
            'user_id'        => auth()->id(),
            'status'         => 'draft',
            'subtotal'       => $subtotal,
            'tax'            => $taxAmount,
            'total'          => $total,
            'notes'          => $request->notes,
            'due_date'       => $request->due_date,
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            InvoiceItem::create([
                'invoice_id'  => $invoice->id,
                'product_id'  => $product->id,
                'description' => $product->name,
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'total'       => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Facture créée avec succès.');
    }

    public function show(Invoice $invoice) {
        $invoice->load(['client', 'user', 'items.product']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice) {
        $request->validate(['status' => 'required|in:draft,sent,paid,cancelled']);
        $invoice->update(['status' => $request->status]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function exportPdf(Invoice $invoice) {
        $invoice->load(['client', 'user', 'items.product']);
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('facture-' . $invoice->invoice_number . '.pdf');
    }

    public function destroy(Invoice $invoice) {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Facture supprimée.');
    }
}