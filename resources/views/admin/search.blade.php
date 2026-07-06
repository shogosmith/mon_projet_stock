@extends('layouts.admin')
@section('title', 'Recherche')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">
        <i class="bi bi-search me-2"></i>Résultats pour "{{ $query }}"
    </h4>
    @isset($total)
        <p class="text-muted">{{ $total }} résultat(s) trouvé(s)</p>
    @endisset
</div>

@if(isset($total) && $total === 0)
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">Aucun résultat pour "{{ $query }}"</h5>
            <p class="text-muted small">Essayez avec d'autres mots-clés</p>
        </div>
    </div>
@endif

{{-- Produits --}}
@if(isset($products) && $products->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-box-seam me-2 text-primary"></i>
        Produits ({{ $products->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nom</th><th>Référence</th><th>Catégorie</th><th>Stock</th><th>Prix</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->name }}</td>
                    <td><code>{{ $p->reference }}</code></td>
                    <td>{{ $p->category->name ?? '—' }}</td>
                    <td class="{{ $p->isLowStock() ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                        {{ $p->quantity }}
                    </td>
                    <td>{{ number_format($p->price, 0, ',', ' ') }} F</td>
                    <td>
                        <a href="{{ route('admin.products.show', $p) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Fournisseurs --}}
@if(isset($suppliers) && $suppliers->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-truck me-2 text-success"></i>
        Fournisseurs ({{ $suppliers->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nom</th><th>Email</th><th>Téléphone</th><th>Pays</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($suppliers as $s)
                <tr>
                    <td class="fw-semibold">{{ $s->name }}</td>
                    <td>{{ $s->email ?? '—' }}</td>
                    <td>{{ $s->phone ?? '—' }}</td>
                    <td>{{ $s->country ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.suppliers.show', $s) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Commandes --}}
@if(isset($orders) && $orders->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-cart3 me-2 text-warning"></i>
        Commandes ({{ $orders->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>N° Commande</th><th>Fournisseur</th><th>Créé par</th><th>Statut</th><th>Total</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                @php
                    $badges = ['pending'=>'warning','approved'=>'info','received'=>'success','cancelled'=>'danger'];
                    $labels = ['pending'=>'En attente','approved'=>'Approuvée','received'=>'Reçue','cancelled'=>'Annulée'];
                @endphp
                <tr>
                    <td><code>{{ $o->order_number }}</code></td>
                    <td>{{ $o->supplier->name ?? '—' }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td><span class="badge bg-{{ $badges[$o->status] }}">{{ $labels[$o->status] }}</span></td>
                    <td>{{ number_format($o->total, 0, ',', ' ') }} F</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Employés --}}
@if(isset($users) && $users->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-people me-2 text-info"></i>
        Employés ({{ $users->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nom</th><th>Email</th><th>Téléphone</th><th>Statut</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone ?? '—' }}</td>
                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Désactivé</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection