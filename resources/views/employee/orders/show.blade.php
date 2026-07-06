@extends('layouts.employee')
@section('title', 'Détail commande')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Commande : {{ $order->order_number }}</h4>
    <a href="{{ route('employee.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Informations</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>N°</th><td><code>{{ $order->order_number }}</code></td></tr>
                    <tr><th>Fournisseur</th><td>{{ $order->supplier->name ?? '—' }}</td></tr>
                    <tr><th>Date</th><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Total</th><td class="fw-bold">{{ number_format($order->total, 0, ',', ' ') }} F</td></tr>
                    <tr><th>Notes</th><td>{{ $order->notes ?? '—' }}</td></tr>
                    <tr>
                        <th>Statut</th>
                        <td>
                            @php
                                $badges = ['pending'=>'warning','approved'=>'info','received'=>'success','cancelled'=>'danger'];
                                $labels = ['pending'=>'En attente','approved'=>'Approuvée','received'=>'Reçue','cancelled'=>'Annulée'];
                            @endphp
                            <span class="badge bg-{{ $badges[$order->status] }}">
                                {{ $labels[$order->status] }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Articles commandés</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr><th>Produit</th><th>Quantité</th><th>Prix unitaire</th><th>Sous-total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 0, ',', ' ') }} F</td>
                            <td class="fw-bold">{{ number_format($item->quantity * $item->unit_price, 0, ',', ' ') }} F</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold text-primary">{{ number_format($order->total, 0, ',', ' ') }} F</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection