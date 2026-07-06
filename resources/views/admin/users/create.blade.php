@extends('layouts.admin')
@section('title', 'Nouvel employé')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvel employé</h4>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom complet *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mot de passe *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmer mot de passe *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Créer l'employé
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection