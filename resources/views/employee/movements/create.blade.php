@extends('layouts.employee')
@section('title', 'Nouveau mouvement')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouveau mouvement de stock</h4>
    <a href="{{ route('employee.movements.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:650px">
    <div class="card-body">
        <form method="POST" action="{{ route('employee.movements.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Produit *</label>
                <select name="product_id" class="form-select" required>
                    <option value="">Choisir un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} — Stock actuel : {{ $product->quantity }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Type de mouvement *</label>
                <select name="type" class="form-select" required>
                    <option value="">Choisir le type</option>
                    <option value="in" {{ old('type') === 'in' ? 'selected' : '' }}>
                        📥 Entrée (réception de stock)
                    </option>
                    <option value="out" {{ old('type') === 'out' ? 'selected' : '' }}>
                        📤 Sortie (vente ou utilisation)
                    </option>
                    <option value="adjustment" {{ old('type') === 'adjustment' ? 'selected' : '' }}>
                        🔧 Ajustement (correction manuelle)
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Quantité *</label>
                <input type="number" name="quantity" class="form-control"
                    value="{{ old('quantity') }}" min="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Raison</label>
                <input type="text" name="reason" class="form-control"
                    value="{{ old('reason') }}"
                    placeholder="Ex: Livraison fournisseur, Vente client...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Référence</label>
                <input type="text" name="reference" class="form-control"
                    value="{{ old('reference') }}"
                    placeholder="Ex: BON-2024-001">
            </div>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Enregistrer le mouvement
            </button>
        </form>
    </div>
</div>

@endsection