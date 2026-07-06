@extends('layouts.admin')
@section('title', 'Historique des connexions')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-clock-history me-2"></i>Historique des connexions
    </h4>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('admin.login_histories.clear_old') }}"
            onsubmit="return confirm('Supprimer les connexions de plus de 30 jours ?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-warning btn-sm" style="border-radius:8px;">
                <i class="bi bi-clock-history me-1"></i> Nettoyer (+30j)
            </button>
        </form>
        <form method="POST" action="{{ route('admin.login_histories.clear') }}"
            onsubmit="return confirm('Vider tout l\'historique ? Cette action est irréversible.')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm" style="border-radius:8px;">
                <i class="bi bi-trash me-1"></i> Tout vider
            </button>
        </form>
    </div>
</div>

{{-- Filtre --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="user_id" class="form-select">
                    <option value="">Tous les employés</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('user_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;">
                    <i class="bi bi-search me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Adresse IP</th>
                        <th>Appareil</th>
                        <th>Date et heure</th>
                        <th>Il y a</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $h)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $h->user->name }}</div>
                            <small class="text-muted">{{ $h->user->email }}</small>
                        </td>
                        <td>
                            @if($h->user->isAdmin())
                                <span class="badge bg-primary">Admin</span>
                            @else
                                <span class="badge bg-success">Employé</span>
                            @endif
                        </td>
                        <td><code>{{ $h->ip_address ?? '—' }}</code></td>
                        <td>
                            @if($h->device === 'Mobile')
                                <i class="bi bi-phone me-1"></i> Mobile
                            @elseif($h->device === 'Tablette')
                                <i class="bi bi-tablet me-1"></i> Tablette
                            @else
                                <i class="bi bi-laptop me-1"></i> Ordinateur
                            @endif
                        </td>
                        <td>{{ $h->logged_in_at->format('d/m/Y H:i:s') }}</td>
                        <td class="text-muted small">{{ $h->logged_in_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                            Aucune connexion enregistrée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($histories->hasPages())
    <div class="card-footer bg-white">{{ $histories->links() }}</div>
    @endif
</div>

@endsection