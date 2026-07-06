@extends('layouts.admin')
@section('title', 'Produits')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Liste des produits</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau produit
    </a>
</div>

{{-- Filtres --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou référence..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Stock faible</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Référence</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $product->name }}</div>
                        @if($product->supplier)
                            <small class="text-muted">{{ $product->supplier->name }}</small>
                        @endif
                    </td>
                    <td><code>{{ $product->reference }}</code></td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} F</td>
                    <td>
                        @if($product->isLowStock())
                            <span class="text-danger fw-bold">{{ $product->quantity }}</span>
                            <i class="bi bi-exclamation-triangle text-danger ms-1"></i>
                        @else
                            <span class="text-success fw-bold">{{ $product->quantity }}</span>
                        @endif
                        <small class="text-muted">/ {{ $product->alert_quantity }}</small>
                    </td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                        Aucun produit trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection