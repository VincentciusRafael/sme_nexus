@extends('layouts.business-autopsy-admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')
@section('subheader', 'Pantau pengguna, master data, aturan, dan hasil diagnosis')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="ba-card ba-card-body ba-stat h-100">
                <span class="ba-stat-label">Pengguna</span>
                <span class="ba-stat-value">{{ $summary['users'] }}</span>
                <span class="small ba-muted">{{ $summary['owners'] }} pemilik UMKM</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ba-card ba-card-body ba-stat h-100">
                <span class="ba-stat-label">Profil UMKM</span>
                <span class="ba-stat-value">{{ $summary['profiles'] }}</span>
                <span class="small ba-muted">Profil usaha terdaftar</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ba-card ba-card-body ba-stat h-100">
                <span class="ba-stat-label">Rule aktif</span>
                <span class="ba-stat-value">{{ $summary['rules'] }}</span>
                <span class="small ba-muted">Aturan siap dievaluasi</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="ba-card ba-card-body ba-stat h-100">
                <span class="ba-stat-label">Rekomendasi aktif</span>
                <span class="ba-stat-value">{{ $summary['recommendations'] }}</span>
                <span class="small ba-muted">Tindak lanjut diagnosis</span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="ba-card h-100">
                <div class="ba-card-body">
                    <h2 class="ba-page-title h5 mb-1">Fondasi master data</h2>
                    <p class="ba-muted mb-3 small">Lengkapi gejala, diagnosis, rule, dan rekomendasi sebelum UMKM menjalankan analisis.</p>

                    <div class="row g-2 mb-3">
                        <div class="col-6"><div class="border rounded-3 p-3"><div class="small ba-muted">Gejala aktif</div><div class="fs-4 fw-bold">{{ $summary['symptoms'] }}</div></div></div>
                        <div class="col-6"><div class="border rounded-3 p-3"><div class="small ba-muted">Diagnosis aktif</div><div class="fs-4 fw-bold">{{ $summary['diagnoses'] }}</div></div></div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-sm ba-btn-primary text-white" href="{{ route('admin.business-autopsy.symptoms.index') }}">Kelola Gejala</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.business-autopsy.diagnoses.index') }}">Kelola Diagnosis</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.business-autopsy.rules.index') }}">Kelola Rule</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.business-autopsy.recommendations.index') }}">Kelola Rekomendasi</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="ba-card h-100">
                <div class="ba-card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="ba-page-title h5 mb-0">Aktivitas terbaru</h2>
                        <a class="small" href="{{ route('admin.business-autopsy.audit.index') }}">Lihat semua</a>
                    </div>

                    @forelse ($summary['recent_logs'] as $log)
                        <div class="d-flex justify-content-between gap-2 py-2 border-bottom">
                            <div>
                                <div class="small fw-semibold">{{ $log->action }}</div>
                                <div class="small ba-muted">{{ $log->user?->full_name ?? 'Sistem' }} &middot; {{ $log->entity_type }}</div>
                            </div>
                            <div class="small ba-muted text-nowrap">{{ $log->created_at?->format('d/m H:i') }}</div>
                        </div>
                    @empty
                        <div class="ba-empty">Belum ada aktivitas audit.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
