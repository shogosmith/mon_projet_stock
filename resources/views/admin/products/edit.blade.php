@extends('layouts.admin')
@section('title', 'Modifier le produit')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier : {{ $product->name }}</h4>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom du produit *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Référence *</label>
                    <input type="text" name="reference" class="form-control" value="{{ old('reference', $product->reference) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <select name="category_id" class="form-select">
                        <option value="">Choisir une catégorie</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fournisseur</label>
                    <select name="supplier_id" class="form-select">
                        <option value="">Choisir un fournisseur</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix (FCFA) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quantité *</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Seuil d'alerte *</label>
                    <input type="number" name="alert_quantity" class="form-control" value="{{ old('alert_quantity', $product->alert_quantity) }}" min="0" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Image</label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" height="60" class="rounded">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="bi bi-check-circle me-1"></i> Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection