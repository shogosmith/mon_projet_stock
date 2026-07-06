@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Total produits</div>
                    <div class="fs-2 fw-bold text-primary">{{ $stats['total_products'] }}</div>
                </div>
                <div class="bg-primary bg-opacity-10 rounded p-2">
                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card border-start border-danger border-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Stock faible</div>
                    <div class="fs-2 fw-bold text-danger">{{ $stats['low_stock'] }}</div>
                </div>
                <div class="bg-danger bg-opacity-10 rounded p-2">
                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Employés</div>
                    <div class="fs-2 fw-bold text-success">{{ $stats['total_employees'] }}</div>
                </div>
                <div class="bg-success bg-opacity-10 rounded p-2">
                    <i class="bi bi-people fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Valeur du stock</div>
                    <div class="fs-3 fw-bold text-warning">{{ number_format($stats['total_value'], 0, ',', ' ') }} F</div>
                </div>
                <div class="bg-warning bg-opacity-10 rounded p-2">
                    <i class="bi bi-cash-stack fs-4 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Graphiques --}}
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-graph-up me-2 text-primary"></i>Mouvements des 7 derniers jours
            </div>
            <div class="card-body">
                <canvas id="movementsChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-pie-chart me-2 text-success"></i>Produits par catégorie
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-bar-chart me-2 text-warning"></i>Valeur du stock par catégorie
            </div>
            <div class="card-body">
                <canvas id="valueChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i> Stock faible
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Stock</th><th>Seuil</th><th>Statut</th></tr>
                    </thead>
                    <tbody>
                        @forelse($low_stock_products as $p)
                        <tr>
                            <td><a href="{{ route('admin.products.show', $p) }}" class="text-decoration-none">{{ $p->name }}</a></td>
                            <td class="text-danger fw-bold">{{ $p->quantity }}</td>
                            <td class="text-muted">{{ $p->alert_quantity }}</td>
                            <td>
                                @if($p->quantity == 0)
                                    <span class="badge bg-danger">Rupture</span>
                                @else
                                    <span class="badge bg-warning">Faible</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Tout le stock est suffisant ✅</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Derniers mouvements --}}
<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-arrow-left-right me-2"></i>Derniers mouvements</span>
                <a href="{{ route('admin.movements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Type</th><th>Quantité</th><th>Par</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recent_movements as $m)
                        <tr>
                            <td>{{ $m->product->name }}</td>
                            <td>
                                @if($m->type === 'in') <span class="badge-in">Entrée</span>
                                @elseif($m->type === 'out') <span class="badge-out">Sortie</span>
                                @else <span class="badge-adjustment">Ajustement</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $m->quantity }}</td>
                            <td>{{ $m->user->name }}</td>
                            <td class="text-muted small">{{ $m->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucun mouvement</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Actions rapides</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un produit
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-person-plus me-1"></i> Ajouter un employé
                </a>
                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-info btn-sm text-white">
                    <i class="bi bi-truck me-1"></i> Ajouter un fournisseur
                </a>
                <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-download me-1"></i> Exporter le stock CSV
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white fw-semibold">Commandes en attente</div>
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-warning">{{ $stats['pending_orders'] }}</div>
                <div class="text-muted small mb-2">commandes à traiter</div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-cart me-1"></i> Voir les commandes
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique mouvements
const ctx1 = document.getElementById('movementsChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: {!! json_encode($chart_labels) !!},
        datasets: [
            {
                label: 'Entrées',
                data: {!! json_encode($chart_in) !!},
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Sorties',
                data: {!! json_encode($chart_out) !!},
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.1)',
                tension: 0.4,
                fill: true,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Graphique catégories
const ctx2 = document.getElementById('categoriesChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($categories_chart->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($categories_chart->pluck('products_count')) !!},
            backgroundColor: ['#ff6a00','#22c55e','#3b82f6','#f59e0b','#ec4899','#8b5cf6'],
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
    }
});

// Graphique valeur
const ctx3 = document.getElementById('valueChart').getContext('2d');
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: {!! json_encode($value_chart->pluck('name')) !!},
        datasets: [{
            label: 'Valeur (FCFA)',
            data: {!! json_encode($value_chart->pluck('total_value')) !!},
            backgroundColor: 'rgba(255,106,0,0.7)',
            borderColor: '#ff6a00',
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush

@endsection