@extends('layouts.admin')
@section('title', 'Modifier fournisseur')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier : {{ $supplier->name }}</h4>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pays</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $supplier->country) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Adresse</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $supplier->address) }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection