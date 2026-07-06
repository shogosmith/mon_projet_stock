@extends('layouts.admin')
@section('title', 'Inventaires')
@section('content')

<h4 class="fw-bold mb-4">Inventaires physiques</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Référence</th>
                    <th>Effectué par</th>
                    <th>Nb produits</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inv)
                <tr>
                    <td><code>{{ $inv->reference }}</code></td>
                    <td>{{ $inv->user->name }}</td>
                    <td><span class="badge bg-primary">{{ $inv->items_count }}</span></td>
                    <td>
                        @if($inv->status === 'completed')
                            <span class="badge bg-success">Complété</span>
                        @else
                            <span class="badge bg-warning">Brouillon</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $inv->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.inventories.show', $inv) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">Aucun inventaire</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($inventories->hasPages())
    <div class="card-footer bg-white">{{ $inventories->links() }}</div>
    @endif
</div>

@endsection