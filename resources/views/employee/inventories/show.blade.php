@extends('layouts.employee')
@section('title', 'Détail inventaire')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Inventaire : {{ $inventory->reference }}</h4>
    <a href="{{ route('employee.inventories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Référence :</strong> <code>{{ $inventory->reference }}</code></div>
            <div class="col-md-3"><strong>Date :</strong> {{ $inventory->created_at->format('d/m/Y H:i') }}</div>
            <div class="col-md-3"><strong>Notes :</strong> {{ $inventory->notes ?? '—' }}</div>
            <div class="col-md-3">
                <strong>Écarts :</strong>
                <span class="badge bg-{{ $inventory->items->where('difference', '!=', 0)->count() > 0 ? 'danger' : 'success' }}">
                    {{ $inventory->items->where('difference', '!=', 0)->count() }} écart(s)
                </span>
            </div>
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