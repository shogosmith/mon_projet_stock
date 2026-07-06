@extends('layouts.employee')
@section('title', 'Mes commandes')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Mes commandes</h4>
    <a href="{{ route('employee.orders.create') }}" class="btn btn-primary">
        <i class="bi bi-cart-plus me-1"></i> Nouvelle commande
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>N° Commande</th>
                    <th>Fournisseur</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><code>{{ $order->order_number }}</code></td>
                    <td>{{ $order->supplier->name ?? '—' }}</td>
                    <td>
                        @php
                            $badges = ['pending'=>'warning','approved'=>'info','received'=>'success','cancelled'=>'danger'];
                            $labels = ['pending'=>'En attente','approved'=>'Approuvée','received'=>'Reçue','cancelled'=>'Annulée'];
                        @endphp
                        <span class="badge bg-{{ $badges[$order->status] }}">
                            {{ $labels[$order->status] }}
                        </span>
                    </td>
                    <td>{{ number_format($order->total, 0, ',', ' ') }} F</td>
                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('employee.orders.show', $order) }}"
                            class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">Aucune commande</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->links() }}</div>
    @endif
</div>

@endsection