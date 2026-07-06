@extends('layouts.admin')
@section('title', 'Paramètres Entreprise')
@section('content')

<h4 class="fw-bold mb-4">
    <i class="bi bi-building me-2"></i>Paramètres de l'entreprise
</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-4">

                {{-- Informations générales --}}
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="bi bi-info-circle me-2"></i>Informations générales
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom de l'entreprise *</label>
                    <input type="text" name="company_name" class="form-control"
                        value="{{ old('company_name', $settings->company_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Slogan</label>
                    <input type="text" name="slogan" class="form-control"
                        value="{{ old('slogan', $settings->slogan) }}"
                        placeholder="Ex: Votre partenaire de confiance">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Téléphone principal</label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $settings->phone) }}"
                        placeholder="+229 00000000">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Téléphone secondaire</label>
                    <input type="text" name="phone2" class="form-control"
                        value="{{ old('phone2', $settings->phone2) }}"
                        placeholder="+229 00000000">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $settings->email) }}"
                        placeholder="contact@entreprise.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Site web</label>
                    <input type="text" name="website" class="form-control"
                        value="{{ old('website', $settings->website) }}"
                        placeholder="www.entreprise.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Devise</label>
                    <select name="currency" class="form-select">
                        <option value="FCFA" {{ $settings->currency === 'FCFA' ? 'selected' : '' }}>FCFA</option>
                        <option value="EUR" {{ $settings->currency === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="USD" {{ $settings->currency === 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="XOF" {{ $settings->currency === 'XOF' ? 'selected' : '' }}>XOF</option>
                    </select>
                </div>

                {{-- Adresse --}}
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mt-2">
                        <i class="bi bi-geo-alt me-2"></i>Adresse
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Adresse</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $settings->address) }}"
                        placeholder="Rue, Quartier...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Ville</label>
                    <input type="text" name="city" class="form-control"
                        value="{{ old('city', $settings->city) }}"
                        placeholder="Ex: Cotonou">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Pays</label>
                    <input type="text" name="country" class="form-control"
                        value="{{ old('country', $settings->country) }}"
                        placeholder="Ex: Bénin">
                </div>

                {{-- Informations légales --}}
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mt-2">
                        <i class="bi bi-shield-check me-2"></i>Informations légales
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">RCCM</label>
                    <input type="text" name="rccm" class="form-control"
                        value="{{ old('rccm', $settings->rccm) }}"
                        placeholder="Ex: RB/COT/22 A 12345">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">IFU (Numéro Fiscal)</label>
                    <input type="text" name="ifu" class="form-control"
                        value="{{ old('ifu', $settings->ifu) }}"
                        placeholder="Ex: 3202200123456">
                </div>

                {{-- Logo et Cachet --}}
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mt-2">
                        <i class="bi bi-image me-2"></i>Logo et Cachet
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Logo de l'entreprise</label>
                    @if($settings->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings->logo) }}"
                                height="60" class="rounded border p-1">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    <small class="text-muted">PNG ou JPG recommandé, fond transparent</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cachet / Tampon</label>
                    @if($settings->stamp)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings->stamp) }}"
                                height="60" class="rounded border p-1">
                        </div>
                    @endif
                    <input type="file" name="stamp" class="form-control" accept="image/*">
                    <small class="text-muted">Image du cachet commercial (PNG fond transparent)</small>
                </div>

                {{-- Pied de facture --}}
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mt-2">
                        <i class="bi bi-file-text me-2"></i>Pied de facture
                    </h6>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Texte en bas de chaque facture</label>
                    <textarea name="invoice_footer" class="form-control" rows="3"
                        placeholder="Ex: Merci pour votre confiance. Tout article vendu ne sera ni repris ni échangé.">{{ old('invoice_footer', $settings->invoice_footer) }}</textarea>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-check-circle me-2"></i>Sauvegarder les paramètres
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection