@extends('layouts.admin')
@section('title', 'Nouvelle facture')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvelle facture</h4>
    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.invoices.store') }}">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Client</label>
                    <select name="client_id" class="form-select">
                        <option value="">Client anonyme</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date d'échéance</label>
                    <input type="date" name="due_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">TVA (%)</label>
                    <input type="number" name="tax" class="form-control" value="0" min="0" max="100" id="tax-input">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Notes optionnelles...">
                </div>
            </div>

            <h6 class="fw-bold mb-3">Articles</h6>
            <div id="items-container">
                <div class="row g-2 mb-2 item-row">
                    <div class="col-md-5">
                        <select name="items[0][product_id]" class="form-select product-select" required>
                            <option value="">Choisir un produit</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}">
                                    {{ $p->name }} — {{ number_format($p->price, 0, ',', ' ') }} F
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[0][quantity]" class="form-control qty-input"
                            placeholder="Qté" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][unit_price]" class="form-control price-input"
                            placeholder="Prix unitaire" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <span class="line-total fw-bold text-primary">0 F</span>
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

            <div class="card bg-light border-0 p-3 mb-4" style="max-width:300px;margin-left:auto">
                <div class="d-flex justify-content-between mb-1">
                    <span>Sous-total</span>
                    <span id="subtotal">0 F</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span>TVA</span>
                    <span id="tax-display">0 F</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span id="total-display" class="text-primary">0 F</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Créer la facture
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let itemCount = 1;

function formatNumber(n) {
    return new Intl.NumberFormat('fr-FR').format(Math.round(n)) + ' F';
}

function updateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty   = parseFloat(row.querySelector('.qty-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const lineTotal = qty * price;
        row.querySelector('.line-total').textContent = formatNumber(lineTotal);
        subtotal += lineTotal;
    });
    const tax   = (parseFloat(document.getElementById('tax-input').value) || 0) / 100;
    const taxAmt = subtotal * tax;
    const total = subtotal + taxAmt;
    document.getElementById('subtotal').textContent    = formatNumber(subtotal);
    document.getElementById('tax-display').textContent = formatNumber(taxAmt);
    document.getElementById('total-display').textContent = formatNumber(total);
}

document.addEventListener('input', updateTotals);

document.querySelectorAll('.product-select').forEach(sel => {
    sel.addEventListener('change', function() {
        const price = this.options[this.selectedIndex].dataset.price || 0;
        this.closest('.item-row').querySelector('.price-input').value = price;
        updateTotals();
    });
});

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 item-row';
    row.innerHTML = `
        <div class="col-md-5">
            <select name="items[${itemCount}][product_id]" class="form-select product-select" required>
                <option value="">Choisir un produit</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} — {{ number_format($p->price, 0, ',', ' ') }} F</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="items[${itemCount}][quantity]" class="form-control qty-input" placeholder="Qté" min="1" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${itemCount}][unit_price]" class="form-control price-input" placeholder="Prix unitaire" min="0" step="0.01" required>
        </div>
        <div class="col-md-1 d-flex align-items-center">
            <span class="line-total fw-bold text-primary">0 F</span>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-remove">
                <i class="bi bi-trash"></i>
            </button>
        </div>`;
    container.appendChild(row);
    itemCount++;

    row.querySelector('.product-select').addEventListener('change', function() {
        const price = this.options[this.selectedIndex].dataset.price || 0;
        this.closest('.item-row').querySelector('.price-input').value = price;
        updateTotals();
    });

    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.disabled = false;
        btn.onclick = function() {
            this.closest('.item-row').remove();
            updateTotals();
        };
    });
});
</script>
@endpush

@endsection