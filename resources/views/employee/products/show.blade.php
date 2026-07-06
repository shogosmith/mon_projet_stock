@extends('layouts.employee')
@section('title', 'Détail produit')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $product->name }}</h4>
    <a href="{{ route('employee.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                        class="img-fluid rounded mb-3" style="max-height:200px">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3"
                        style="height:150px">
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
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Informations</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Catégorie</th><td>{{ $product->category->name ?? '—' }}</td></tr>
                    <tr><th>Fournisseur</th><td>{{ $product->supplier->name ?? '—' }}</td></tr>
                    <tr><th>Prix</th><td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td></tr>
                    <tr><th>Quantité</th><td>{{ $product->quantity }}</td></tr>
                    <tr><th>Seuil alerte</th><td>{{ $product->alert_quantity }}</td></tr>
                    <tr><th>Description</th><td>{{ $product->description ?? '—' }}</td></tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('employee.movements.create') }}"
                        class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Faire un mouvement sur ce produit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection