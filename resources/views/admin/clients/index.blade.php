@extends('layouts.admin')
@section('title', 'Clients')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Clients</h4>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Nouveau client
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nom</th><th>Email</th><th>Téléphone</th><th>Pays</th><th>Factures</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td class="fw-semibold">{{ $client->name }}</td>
                    <td>{{ $client->email ?? '—' }}</td>
                    <td>{{ $client->phone ?? '—' }}</td>
                    <td>{{ $client->country ?? '—' }}</td>
                    <td><span class="badge bg-primary">{{ $client->invoices_count }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}"
                                onsubmit="return confirm('Supprimer ce client ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Aucun client</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($clients->hasPages())
    <div class="card-footer bg-white">{{ $clients->links() }}</div>
    @endif
</div>

@endsection