@extends('layouts.employee')
@section('title', 'Dashboard')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-1">Total produits</div>
                <div class="fs-2 fw-bold text-primary">{{ $stats['total_products'] }}</div>
                <div class="text-muted small"><i class="bi bi-box-seam me-1"></i>Disponibles</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-start border-danger border-3">
            <div class="card-body">
                <div class="text-muted small mb-1">Stock faible</div>
                <div class="fs-2 fw-bold text-danger">{{ $stats['low_stock'] }}</div>
                <div class="text-muted small"><i class="bi bi-exclamation-triangle me-1"></i>Sous le seuil</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small mb-1">Mes mouvements</div>
                <div class="fs-2 fw-bold text-success">{{ $stats['my_movements'] }}</div>
                <div class="text-muted small"><i class="bi bi-arrow-left-right me-1"></i>Total enregistrés</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Mes derniers mouvements</span>
                <a href="{{ route('employee.movements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Type</th>
                            <th>Quantité</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_movements as $m)
                        <tr>
                            <td>{{ $m->product->name }}</td>
                            <td>
                                @if($m->type === 'in')
                                    <span class="badge bg-success">Entrée</span>
                                @elseif($m->type === 'out')
                                    <span class="badge bg-danger">Sortie</span>
                                @else
                                    <span class="badge bg-warning">Ajustement</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $m->quantity }}</td>
                            <td class="text-muted small">{{ $m->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Aucun mouvement pour l'instant
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i> Stock faible
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Stock</th><th>Seuil</th></tr>
                    </thead>
                    <tbody>
                        @forelse($low_stock_products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td class="text-danger fw-bold">{{ $p->quantity }}</td>
                            <td class="text-muted">{{ $p->alert_quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Tout est OK ✅</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Actions rapides</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('employee.movements.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Nouveau mouvement de stock
                </a>
                <a href="{{ route('employee.orders.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-cart-plus me-1"></i> Nouvelle commande
                </a>
                <a href="{{ route('employee.products.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-seam me-1"></i> Voir les produits
                </a>
            </div>
        </div>
    </div>
</div>

@endsection