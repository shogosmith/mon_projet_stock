@extends('layouts.admin')
@section('title', 'Factures')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Factures</h4>
    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouvelle facture
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>N° Facture</th><th>Client</th><th>Statut</th><th>Total</th><th>Échéance</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                @php
                    $badges = ['draft'=>'secondary','sent'=>'info','paid'=>'success','cancelled'=>'danger'];
                    $labels = ['draft'=>'Brouillon','sent'=>'Envoyée','paid'=>'Payée','cancelled'=>'Annulée'];
                @endphp
                <tr>
                    <td><code>{{ $invoice->invoice_number }}</code></td>
                    <td>{{ $invoice->client->name ?? 'Client anonyme' }}</td>
                    <td><span class="badge bg-{{ $badges[$invoice->status] }}">{{ $labels[$invoice->status] }}</span></td>
                    <td class="fw-bold">{{ number_format($invoice->total, 0, ',', ' ') }} F</td>
                    <td class="text-muted small">{{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : '—' }}</td>
                    <td class="text-muted small">{{ $invoice->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.invoices.pdf', $invoice) }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-pdf"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}"
                                onsubmit="return confirm('Supprimer cette facture ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">Aucune facture</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div class="card-footer bg-white">{{ $invoices->links() }}</div>
    @endif
</div>

@endsection