@extends('layouts.admin')
@section('title', 'Nouvelle catégorie')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvelle catégorie</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nom *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Enregistrer
            </button>
        </form>
    </div>
</div>

@endsection