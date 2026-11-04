@extends('layouts.business-autopsy-admin')

@section('title', 'Kategori Bisnis')
@section('header', 'Kategori Bisnis')
@section('subheader', 'Kategori usaha yang digunakan pada profil UMKM')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
        <div>
            <h1 class="ba-page-title h4">Kategori Bisnis</h1>
            <p class="ba-muted mb-0 small">Total {{ $categories->total() }} kategori.</p>
        </div>
        <a class="btn ba-btn-primary text-white" href="{{ route('admin.business-autopsy.categories.create') }}">Tambah Kategori</a>
    </div>

    <div class="ba-card mb-3">
        <div class="ba-card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-8">
                    <label class="form-label small fw-semibold" for="search">Cari</label>
                    <input class="form-control" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama atau deskripsi kategori">
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button class="btn btn-outline-secondary flex-fill" type="submit">Filter</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.business-autopsy.categories.index') }}">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="ba-card">
        <div class="table-responsive">
            <table class="table ba-table ba-table-mobile align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Profil</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td data-label="Kategori"><div class="fw-semibold">{{ $category->category_name }}</div></td>
                            <td data-label="Deskripsi">{{ $category->deskripsi ?: '-' }}</td>
                            <td data-label="Profil">{{ $category->sme_profiles_count }} profil</td>
                            <td data-label="Aksi" class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.business-autopsy.categories.edit', $category) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.business-autopsy.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"><div class="ba-empty">Belum ada kategori bisnis.</div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="ba-card-body border-top">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
