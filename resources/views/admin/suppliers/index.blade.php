@extends('layouts.admin')
@section('title', 'Fournisseurs')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Fournisseurs</h4>
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau fournisseur
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Pays</th>
                    <th>Produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td class="fw-semibold">{{ $supplier->name }}</td>
                    <td>{{ $supplier->email ?? '—' }}</td>
                    <td>{{ $supplier->phone ?? '—' }}</td>
                    <td>{{ $supplier->country ?? '—' }}</td>
                    <td><span class="badge bg-info">{{ $supplier->products_count }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                onsubmit="return confirm('Supprimer ce fournisseur ?')">
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
                    <td colspan="6" class="text-center text-muted py-5">Aucun fournisseur</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
    <div class="card-footer bg-white">{{ $suppliers->links() }}</div>
    @endif
</div>

@endsection