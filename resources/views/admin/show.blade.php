@extends('layouts.admin')
@section('title', 'Détail inventaire')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Inventaire : {{ $inventory->reference }}</h4>
    <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

@if($ecarts > 0)
<div class="alert alert-warning d-flex align-items-center mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
    <div>
        <strong>Attention !</strong> {{ $ecarts }} écart(s) détecté(s) entre le stock théorique et le stock physique.
    </div>
</div>
@else
<div class="alert alert-success mb-4">
    <i class="bi bi-check-circle me-2"></i>
    Aucun écart détecté — le stock physique correspond au stock théorique.
</div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Référence :</strong> <code>{{ $inventory->reference }}</code></div>
            <div class="col-md-3"><strong>Effectué par :</strong> {{ $inventory->user->name }}</div>
            <div class="col-md-3"><strong>Date :</strong> {{ $inventory->created_at->format('d/m/Y H:i') }}</div>
            <div class="col-md-3"><strong>Notes :</strong> {{ $inventory->notes ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Stock théorique</th>
                    <th>Quantité comptée</th>
                    <th>Écart</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventory->items as $item)
                <tr class="{{ $item->difference != 0 ? 'table-warning' : '' }}">
                    <td class="fw-semibold">{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->theoretical_quantity }}</td>
                    <td class="text-center fw-bold">{{ $item->physical_quantity }}</td>
                    <td class="text-center fw-bold {{ $item->difference > 0 ? 'text-success' : ($item->difference < 0 ? 'text-danger' : 'text-muted') }}">
                        {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                    </td>
                    <td>
                        @if($item->difference == 0)
                            <span class="badge bg-success">OK</span>
                        @elseif($item->difference > 0)
                            <span class="badge bg-info">Surplus</span>
                        @else
                            <span class="badge bg-danger">Manquant</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection