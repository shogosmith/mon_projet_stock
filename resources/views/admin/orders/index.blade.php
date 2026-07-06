@extends('layouts.admin')
@section('title', 'Commandes')
@section('content')

<h4 class="fw-bold mb-4">Toutes les commandes</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>N° Commande</th>
                    <th>Fournisseur</th>
                    <th>Créé par</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><code>{{ $order->order_number }}</code></td>
                    <td>{{ $order->supplier->name ?? '—' }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>
                        @php
                            $badges = [
                                'pending'   => 'warning',
                                'approved'  => 'info',
                                'received'  => 'success',
                                'cancelled' => 'danger',
                            ];
                            $labels = [
                                'pending'   => 'En attente',
                                'approved'  => 'Approuvée',
                                'received'  => 'Reçue',
                                'cancelled' => 'Annulée',
                            ];
                        @endphp
                        <span class="badge bg-{{ $badges[$order->status] }}">
                            {{ $labels[$order->status] }}
                        </span>
                    </td>
                    <td>{{ number_format($order->total, 0, ',', ' ') }} F</td>
                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                onsubmit="return confirm('Supprimer cette commande ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">Aucune commande</td>
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