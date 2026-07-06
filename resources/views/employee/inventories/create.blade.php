@extends('layouts.employee')
@section('title', 'Nouvel inventaire')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvel inventaire physique</h4>
    <a href="{{ route('employee.inventories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Comptez physiquement chaque produit dans le magasin et entrez la quantité réelle que vous voyez.
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('employee.inventories.store') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">Notes</label>
                <input type="text" name="notes" class="form-control"
                    placeholder="Ex: Inventaire mensuel juin 2024">
            </div>

            <h6 class="fw-bold mb-3">Produits à compter</h6>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Référence</th>
                            <th>Stock théorique</th>
                            <th>Quantité comptée *</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $i => $product)
                        <tr>
                            <td class="fw-semibold">
                                {{ $product->name }}
                                <input type="hidden" name="items[{{ $i }}][product_id]"
                                    value="{{ $product->id }}">
                            </td>
                            <td><code>{{ $product->reference }}</code></td>
                            <td class="text-center fw-bold text-primary">{{ $product->quantity }}</td>
                            <td>
                                <input type="number"
                                    name="items[{{ $i }}][physical_quantity]"
                                    class="form-control form-control-sm"
                                    placeholder="0"
                                    min="0"
                                    required>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary px-4 mt-3">
                <i class="bi bi-check-circle me-1"></i> Soumettre l'inventaire
            </button>
        </form>
    </div>
</div>

@endsection