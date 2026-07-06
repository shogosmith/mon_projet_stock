@extends('layouts.employee')
@section('title', 'Produits')
@section('content')

<h4 class="fw-bold mb-4">Liste des produits</h4>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                    placeholder="Rechercher par nom ou référence..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
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
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Référence</th>
                    <th>Catégorie</th>
                    <th>Stock</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="fw-semibold">{{ $product->name }}</td>
                    <td><code>{{ $product->reference }}</code></td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>
                        @if($product->isLowStock())
                            <span class="text-danger fw-bold">{{ $product->quantity }}</span>
                            <i class="bi bi-exclamation-triangle text-danger ms-1"></i>
                        @else
                            <span class="text-success fw-bold">{{ $product->quantity }}</span>
                        @endif
                    </td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} F</td>
                    <td>
                        <a href="{{ route('employee.products.show', $product) }}"
                            class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">Aucun produit trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white">{{ $products->links() }}</div>
    @endif
</div>

@endsection