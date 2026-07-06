@extends('layouts.employee')
@section('title', 'Mes mouvements')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Mes mouvements de stock</h4>
    <a href="{{ route('employee.movements.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau mouvement
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Type</th>
                    <th>Quantité</th>
                    <th>Avant</th>
                    <th>Après</th>
                    <th>Raison</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                <tr>
                    <td class="fw-semibold">{{ $m->product->name }}</td>
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
                    <td class="text-muted">{{ $m->quantity_before }}</td>
                    <td class="text-muted">{{ $m->quantity_after }}</td>
                    <td>{{ $m->reason ?? '—' }}</td>
                    <td class="text-muted small">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                        Aucun mouvement enregistré
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($movements->hasPages())
    <div class="card-footer bg-white">{{ $movements->links() }}</div>
    @endif
</div>

@endsection