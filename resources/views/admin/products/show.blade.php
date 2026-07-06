@extends('layouts.admin')
@section('title', 'Détail produit')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $product->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-3" style="max-height:200px">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height:150px">
                        <i class="bi bi-image fs-1 text-muted"></i>
                    </div>
                @endif
                <h5 class="fw-bold">{{ $product->name }}</h5>
                <code>{{ $product->reference }}</code>
                <div class="mt-3">
                    @if($product->isLowStock())
                        <span class="badge bg-danger fs-6">⚠ Stock faible : {{ $product->quantity }}</span>
                    @else
                        <span class="badge bg-success fs-6">Stock OK : {{ $product->quantity }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Informations</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Catégorie</th><td>{{ $product->category->name ?? '—' }}</td></tr>
                    <tr><th>Fournisseur</th><td>{{ $product->supplier->name ?? '—' }}</td></tr>
                    <tr><th>Prix</th><td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td></tr>
                    <tr><th>Quantité</th><td>{{ $product->quantity }}</td></tr>
                    <tr><th>Seuil alerte</th><td>{{ $product->alert_quantity }}</td></tr>
                    <tr><th>Valeur stock</th><td>{{ number_format($product->quantity * $product->price, 0, ',', ' ') }} FCFA</td></tr>
                    <tr><th>Description</th><td>{{ $product->description ?? '—' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Derniers mouvements</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Type</th><th>Quantité</th><th>Avant</th><th>Après</th><th>Par</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($product->stockMovements->take(5) as $m)
                        <tr>
                            <td>
                                @if($m->type === 'in') <span class="badge-in">Entrée</span>
                                @elseif($m->type === 'out') <span class="badge-out">Sortie</span>
                                @else <span class="badge-adjustment">Ajustement</span>
                                @endif
                            </td>
                            <td>{{ $m->quantity }}</td>
                            <td>{{ $m->quantity_before }}</td>
                            <td>{{ $m->quantity_after }}</td>
                            <td>{{ $m->user->name }}</td>
                            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">Aucun mouvement</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection