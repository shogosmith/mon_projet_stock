@extends('layouts.employee')
@section('title', 'Mon profil')
@section('content')

<h4 class="fw-bold mb-4">Mon Profil</h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-5">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:90px;height:90px;background:linear-gradient(135deg,#0d9488,#134e4a)">
                    <span style="color:#fff;font-weight:700;font-size:32px">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge bg-success">Employé</span>
                <div class="mt-3 text-muted small">
                    <i class="bi bi-calendar me-1"></i>
                    Membre depuis {{ $user->created_at->format('d/m/Y') }}
                </div>
                @if($user->phone)
                <div class="mt-1 text-muted small">
                    <i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-person-gear me-2"></i>Modifier mes informations
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employee.profile.update') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom complet *</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Vous pouvez modifier votre adresse email.
                            </small>
                        </div>

                        <div class="col-12 mt-2">
                            <hr>
                            <h6 class="fw-bold text-muted mb-0">Changer le mot de passe</h6>
                            <small class="text-muted">Laissez vide si vous ne voulez pas changer</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control"
                                placeholder="Requis pour changer">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Min. 8 caractères">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Répéter le mot de passe">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection