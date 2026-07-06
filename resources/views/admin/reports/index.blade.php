@extends('layouts.admin')
@section('title', 'Rapports & Statistiques')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Rapports & Statistiques avancées</h4>
   <a href="{{ route('admin.reports.export') }}" class="btn btn-danger">
    <i class="bi bi-file-pdf me-1"></i> Exporter PDF
</a>
</div>

{{-- Stats générales --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="text-muted small mb-1">Valeur totale du stock</div>
            <div class="fs-2 fw-bold text-primary">{{ number_format($total_value, 0, ',', ' ') }} F</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="text-muted small mb-1">Produits en stock faible</div>
            <div class="fs-2 fw-bold text-danger">{{ $low_stock->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="text-muted small mb-1">Risque de rupture (30j)</div>
            <div class="fs-2 fw-bold text-warning">{{ $previsions->count() }}</div>
        </div>
    </div>
</div>

{{-- Graphique évolution valeur stock --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-graph-up me-2 text-primary"></i>Évolution de la valeur du stock (6 derniers mois)
    </div>
    <div class="card-body">
        <canvas id="valueEvolutionChart" height="80"></canvas>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Produits les plus mouvementés --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-fire me-2 text-danger"></i>Produits les plus vendus
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Sorties totales</th></tr>
                    </thead>
                    <tbody>
                        @forelse($top_movements as $m)
                        <tr>
                            <td>{{ $m->product->name ?? '—' }}</td>
                            <td><span class="badge bg-danger">{{ $m->total_sorties }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-3">Aucune donnée</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Taux de rotation --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-arrow-repeat me-2 text-success"></i>Taux de rotation (30 jours)
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Sorties</th><th>Taux</th></tr>
                    </thead>
                    <tbody>
                        @forelse($rotation as $r)
                        <tr>
                            <td>{{ $r['product']->name }}</td>
                            <td>{{ $r['sorties30j'] }}</td>
                            <td>
                                <span class="badge bg-{{ $r['rotation'] > 1 ? 'success' : 'secondary' }}">
                                    {{ $r['rotation'] }}x
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Aucune donnée</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Prévision de rupture --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold text-warning">
        <i class="bi bi-exclamation-diamond me-2"></i>Prévision de rupture de stock (30 prochains jours)
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Stock actuel</th>
                    <th>Vente moyenne/jour</th>
                    <th>Jours restants</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($previsions as $p)
                <tr class="{{ $p['jours_restants'] <= 7 ? 'table-danger' : 'table-warning' }}">
                    <td class="fw-semibold">{{ $p['product']->name }}</td>
                    <td>{{ $p['product']->quantity }}</td>
                    <td>{{ $p['moyenne_jour'] }} / jour</td>
                    <td class="fw-bold">{{ $p['jours_restants'] }} jours</td>
                    <td>
                        @if($p['jours_restants'] <= 7)
                            <span class="badge bg-danger">Urgent</span>
                        @else
                            <span class="badge bg-warning text-dark">À surveiller</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-success py-4">
                        <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                        Aucun risque de rupture détecté
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Stock faible --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold text-danger">
        <i class="bi bi-exclamation-triangle me-1"></i> Produits sous le seuil d'alerte
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr><th>Produit</th><th>Stock</th><th>Seuil</th></tr>
            </thead>
            <tbody>
                @forelse($low_stock as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td class="text-danger fw-bold">{{ $p->quantity }}</td>
                    <td class="text-muted">{{ $p->alert_quantity }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-3">Tout est OK ✅</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('valueEvolutionChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($monthly_value)->pluck('month')) !!},
        datasets: [{
            label: 'Valeur du stock (FCFA)',
            data: {!! json_encode(collect($monthly_value)->pluck('value')) !!},
            borderColor: '#7c3aed',
            backgroundColor: 'rgba(124,58,237,0.1)',
            tension: 0.4,
            fill: true,
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