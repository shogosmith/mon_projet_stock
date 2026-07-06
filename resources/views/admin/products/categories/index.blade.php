@extends('layouts.admin')
@section('title', 'Catégories')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Catégories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouvelle catégorie
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-muted">{{ $category->description ?? '—' }}</td>
                    <td><span class="badge bg-primary">{{ $category->products_count }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                onsubmit="return confirm('Supprimer cette catégorie ?')">
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
                    <td colspan="4" class="text-center text-muted py-5">Aucune catégorie</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white">{{ $categories->links() }}</div>
    @endif
</div>

@endsection