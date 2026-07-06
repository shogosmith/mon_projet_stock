@extends('layouts.employee')
@section('title', 'Nouvelle commande')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvelle commande</h4>
    <a href="{{ route('employee.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('employee.orders.store') }}">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fournisseur</label>
                    <select name="supplier_id" class="form-select">
                        <option value="">Choisir un fournisseur</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Notes</label>
                    <input type="text" name="notes" class="form-control"
                        placeholder="Notes optionnelles...">
                </div>
            </div>

            <h6 class="fw-bold mb-3">Articles</h6>
            <div id="items-container">
                <div class="row g-2 mb-2 item-row">
                    <div class="col-md-5">
                        <select name="items[0][product_id]" class="form-select" required>
                            <option value="">Choisir un produit</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][quantity]"
                            class="form-control" placeholder="Quantité" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][unit_price]"
                            class="form-control" placeholder="Prix unitaire" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-remove" disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-item" class="btn btn-outline-primary btn-sm mb-4">
                <i class="bi bi-plus-circle me-1"></i> Ajouter un article
            </button>

            <div>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-1"></i> Créer la commande
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let itemCount = 1;
document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 item-row';
    row.innerHTML = `
        <div class="col-md-5">
            <select name="items[${itemCount}][product_id]" class="form-select" required>
                <option value="">Choisir un produit</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${itemCount}][quantity]"
                class="form-control" placeholder="Quantité" min="1" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${itemCount}][unit_price]"
                class="form-control" placeholder="Prix unitaire" min="0" step="0.01" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-remove">
                <i class="bi bi-trash"></i>
            </button>
        </div>`;
    container.appendChild(row);
    itemCount++;
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.disabled = false;
        btn.onclick = function() { this.closest('.item-row').remove(); };
    });
});
</script>
@endpush

@endsection