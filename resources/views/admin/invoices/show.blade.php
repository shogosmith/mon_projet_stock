@extends('layouts.admin')
@section('title', 'Facture')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Facture : {{ $invoice->invoice_number }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.invoices.pdf', $invoice) }}" class="btn btn-danger">
            <i class="bi bi-file-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Informations</div>
            <div class="card-body">
                <table class="table table-sm mb-3">
                    <tr><th>N°</th><td><code>{{ $invoice->invoice_number }}</code></td></tr>
                    <tr><th>Client</th><td>{{ $invoice->client->name ?? 'Anonyme' }}</td></tr>
                    <tr><th>Créée par</th><td>{{ $invoice->user->name }}</td></tr>
                    <tr><th>Date</th><td>{{ $invoice->created_at->format('d/m/Y') }}</td></tr>
                    <tr><th>Échéance</th><td>{{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : '—' }}</td></tr>
                    <tr><th>Notes</th><td>{{ $invoice->notes ?? '—' }}</td></tr>
                </table>

                <form method="POST" action="{{ route('admin.invoices.status', $invoice) }}">
                    @csrf @method('PATCH')
                    <label class="form-label fw-semibold small">Changer le statut</label>
                    <select name="status" class="form-select form-select-sm mb-2">
                        <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Envoyée</option>
                        <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Payée</option>
                        <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Sous-total</span>
                    <span>{{ number_format($invoice->subtotal, 0, ',', ' ') }} F</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">TVA</span>
                    <span>{{ number_format($invoice->tax, 0, ',', ' ') }} F</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary">{{ number_format($invoice->total, 0, ',', ' ') }} F</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Articles</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Quantité</th><th>Prix unitaire</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item->description ?? $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 0, ',', ' ') }} F</td>
                            <td class="fw-bold">{{ number_format($item->total, 0, ',', ' ') }} F</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold text-primary">{{ number_format($invoice->total, 0, ',', ' ') }} F</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection