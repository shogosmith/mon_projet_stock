@extends('layouts.admin')
@section('title', 'Mouvements de stock')
@section('content')

<h4 class="fw-bold mb-4">Tous les mouvements de stock</h4>

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
                    <th>Par</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                <tr>
                    <td class="fw-semibold">{{ $m->product->name }}</td>
                    <td>
                        @if($m->type === 'in')
                            <span class="badge-in">Entrée</span>
                        @elseif($m->type === 'out')
                            <span class="badge-out">Sortie</span>
                        @else
                            <span class="badge-adjustment">Ajustement</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $m->quantity }}</td>
                    <td class="text-muted">{{ $m->quantity_before }}</td>
                    <td class="text-muted">{{ $m->quantity_after }}</td>
                    <td>{{ $m->reason ?? '—' }}</td>
                    <td>{{ $m->user->name }}</td>
                    <td class="text-muted small">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">Aucun mouvement</td>
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