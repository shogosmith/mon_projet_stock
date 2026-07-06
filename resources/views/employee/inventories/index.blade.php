@extends('layouts.employee')
@section('title', 'Mes inventaires')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Mes inventaires physiques</h4>
    <a href="{{ route('employee.inventories.create') }}" class="btn btn-primary">
        <i class="bi bi-clipboard-check me-1"></i> Nouvel inventaire
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Référence</th>
                    <th>Statut</th>
                    <th>Notes</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inv)
                <tr>
                    <td><code>{{ $inv->reference }}</code></td>
                    <td>
                        @if($inv->status === 'completed')
                            <span class="badge bg-success">Complété</span>
                        @else
                            <span class="badge bg-warning">Brouillon</span>
                        @endif
                    </td>
                    <td>{{ $inv->notes ?? '—' }}</td>
                    <td class="text-muted small">{{ $inv->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('employee.inventories.show', $inv) }}"
                            class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-clipboard fs-1 d-block mb-2"></i>
                        Aucun inventaire effectué
                    </td>
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