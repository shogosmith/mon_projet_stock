@extends('layouts.admin')
@section('title', 'Alertes Stock')
@section('content')

<h4 class="fw-bold mb-4 text-danger">
    <i class="bi bi-bell-fill me-2"></i>Alertes de stock
</h4>

@if($out_of_stock > 0)
<div class="alert alert-danger d-flex align-items-center mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
    <div>
        <strong>Attention !</strong> {{ $out_of_stock }} produit(s) sont en rupture totale de stock.
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Produits sous le seuil d'alerte ({{ $low_stock_products->count() }})
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Stock actuel</th>
                            <th>Seuil</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($low_stock_products as $p)
                        <tr class="{{ $p->quantity == 0 ? 'table-danger' : 'table-warning' }}">
                            <td class="fw-semibold">{{ $p->name }}</td>
                            <td>{{ $p->category->name ?? '—' }}</td>
                            <td class="fw-bold {{ $p->quantity == 0 ? 'text-danger' : 'text-warning' }}">
                                {{ $p->quantity }}
                            </td>
                            <td>{{ $p->alert_quantity }}</td>
                            <td>
                                @if($p->quantity == 0)
                                    <span class="badge bg-danger">Rupture totale</span>
                                @else
                                    <span class="badge bg-warning text-dark">Stock faible</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $p) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-success py-4">
                                <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                                Tout le stock est suffisant !
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-clock-history me-1"></i> Derniers mouvements
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($recent_movements as $m)
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex justify-content-between">
                            <small class="fw-semibold">{{ $m->product->name }}</small>
                            @if($m->type === 'in')
                                <span class="badge bg-success">+{{ $m->quantity }}</span>
                            @elseif($m->type === 'out')
                                <span class="badge bg-danger">-{{ $m->quantity }}</span>
                            @else
                                <span class="badge bg-warning">={{ $m->quantity }}</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            {{ $m->user->name }} — {{ $m->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection