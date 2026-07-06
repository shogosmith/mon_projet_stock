@extends('layouts.admin')
@section('title', 'Détail fournisseur')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $supplier->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Informations</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Nom</th><td>{{ $supplier->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $supplier->email ?? '—' }}</td></tr>
                    <tr><th>Téléphone</th><td>{{ $supplier->phone ?? '—' }}</td></tr>
                    <tr><th>Adresse</th><td>{{ $supplier->address ?? '—' }}</td></tr>
                    <tr><th>Pays</th><td>{{ $supplier->country ?? '—' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Produits de ce fournisseur</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Référence</th><th>Stock</th><th>Prix</th></tr>
                    </thead>
                    <tbody>
                        @forelse($supplier->products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td><code>{{ $p->reference }}</code></td>
                            <td>{{ $p->quantity }}</td>
                            <td>{{ number_format($p->price, 0, ',', ' ') }} F</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Aucun produit</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection