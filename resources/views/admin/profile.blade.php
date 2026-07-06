@extends('layouts.admin')
@section('title', 'Mon Profil')
@section('content')

<div class="row g-4">
    {{-- Colonne gauche : carte identité --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:90px;height:90px;background:linear-gradient(135deg,#7c3aed,#2d1b69)">
                    <span style="color:#fff;font-weight:700;font-size:32px">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge bg-primary px-3 py-2">Administrateur</span>
                <hr class="my-3">
                <div class="text-start">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-envelope text-primary"></i>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone text-primary"></i>
                        <small class="text-muted">{{ $user->phone ?? 'Non renseigné' }}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar text-primary"></i>
                        <small class="text-muted">Membre depuis {{ $user->created_at->format('d/m/Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Colonne droite : formulaire --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-person-gear me-2 text-primary"></i>Modifier mes informations
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">

                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom complet *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Téléphone --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}" placeholder="+229 00000000">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Séparateur mot de passe --}}
                        <div class="col-12">
                            <hr>
                            <p class="fw-semibold mb-0">Changer le mot de passe</p>
                            <small class="text-muted">Laissez vide si vous ne souhaitez pas changer</small>
                        </div>

                        {{-- Mot de passe actuel --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mot de passe actuel</label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="Requis pour changer">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Nouveau mot de passe --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Min. 8 caractères">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Confirmer --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Répéter le mot de passe">
                        </div>

                        {{-- Bouton --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection