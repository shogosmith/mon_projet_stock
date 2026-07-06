@extends('layouts.admin')
@section('title', 'Employés')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Employés</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Nouvel employé
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
                    <th>Statut</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Désactivé</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                    title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Supprimer cet employé ?')">
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
                    <td colspan="6" class="text-center text-muted py-5">Aucun employé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->links() }}</div>
    @endif
</div>

@endsection