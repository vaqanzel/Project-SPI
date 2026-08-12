@extends('layout.app')
@section('title', 'Dashboard')

@push('style')
<style>
    /* Dashboard-specific overrides */
    .spi-dashboard-wrap .card {
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(15,23,53,0.06);
    }
</style>
@endpush

@section('main')
<div class="main-content spi-dashboard-wrap">
    <section class="section">

        {{-- ─── Page Header ─── --}}
        <div class="spi-page-header">
            <div class="spi-page-header-left">
                <div class="spi-page-breadcrumb">
                    <i class="fas fa-home" style="font-size:0.7rem;"></i>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="spi-page-breadcrumb-current">Dashboard</span>
                </div>
                <h1 class="spi-page-title">Dashboard</h1>
                <p class="spi-page-subtitle">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Berikut ringkasan pengawasan terkini.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url('/posts') }}" class="spi-btn spi-btn-primary">
                    <i class="fas fa-list-check"></i>
                    Lihat Penugasan
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Progress / Summary Cards ─── --}}
            @if (Auth::user()->id_level == 1 || Auth::user()->id_level == 2 || count($assignedPosts) > 0)
            <div class="row mb-4">

                @if (Auth::user()->id_level == 1 || Auth::user()->id_level == 2)
                <div class="col-md-6 mb-4">
                    <div class="spi-card">
                        <div class="spi-card-header">
                            <div>
                                <div class="spi-card-title">Laporan Akhir Terkumpul</div>
                                <div class="spi-card-subtitle">Persentase semua laporan yang telah dikumpulkan</div>
                            </div>
                            <div class="spi-stat-icon spi-stat-icon-blue">
                                <i class="fas fa-file-check"></i>
                            </div>
                        </div>
                        <div class="spi-card-body">
                            <div class="spi-progress-wrapper">
                                <div class="spi-progress-info">
                                    <span class="spi-progress-label">Progress Semua Data</span>
                                    <span class="spi-progress-pct">{{ round($laporanAkhirRate, 1) }}%</span>
                                </div>
                                <div class="spi-progress-track">
                                    <div class="spi-progress-bar" style="width: {{ $laporanAkhirRate }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if (count($assignedPosts) > 0)
                <div class="col-md-6 mb-4">
                    <div class="spi-card">
                        <div class="spi-card-header">
                            <div>
                                <div class="spi-card-title">Laporan Tugas Anda</div>
                                <div class="spi-card-subtitle">Persentase laporan yang telah dikumpulkan dari tugas Anda</div>
                            </div>
                            <div class="spi-stat-icon spi-stat-icon-green">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="spi-card-body">
                            <div class="spi-progress-wrapper">
                                <div class="spi-progress-info">
                                    <span class="spi-progress-label">Progress Tugas Anda</span>
                                    <span class="spi-progress-pct" style="color:#10B981;">{{ round($laporanAkhirRateAssigned, 1) }}%</span>
                                </div>
                                <div class="spi-progress-track">
                                    <div class="spi-progress-bar spi-progress-bar-green" style="width: {{ $laporanAkhirRateAssigned }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            @endif

            {{-- ─── Chart + Bidang Stats Row ─── --}}
            <div class="row">

                {{-- Chart Data Penugasan --}}
                <div class="col-xl-7 col-xxl-7 mb-4">
                    <div class="spi-card h-100">
                        <div class="spi-card-header">
                            <div>
                                <div class="spi-card-title">Data Penugasan</div>
                                <div class="spi-card-subtitle">Distribusi penugasan berdasarkan kategori dan status</div>
                            </div>
                            <span class="spi-badge spi-badge-primary">
                                <i class="fas fa-chart-bar"></i>
                                Chart
                            </span>
                        </div>
                        <div class="spi-card-body">
                            {!! $tugasLaporChart->container() !!}
                        </div>
                    </div>
                </div>

                {{-- Bidang Count Cards --}}
                <div class="col-xl-5 col-xxl-5 mb-4">
                    <div class="spi-card h-100">
                        <div class="spi-card-header">
                            <div>
                                <div class="spi-card-title">Statistik Bidang</div>
                                <div class="spi-card-subtitle">Jumlah kegiatan per bidang pengawasan</div>
                            </div>
                        </div>
                        <div class="spi-card-body" style="padding:16px 24px;">

                            @php
                                $iconColors = [
                                    ['icon' => 'fas fa-briefcase',       'color' => 'spi-stat-icon-blue'],
                                    ['icon' => 'fas fa-leaf',            'color' => 'spi-stat-icon-green'],
                                    ['icon' => 'fas fa-triangle-exclamation', 'color' => 'spi-stat-icon-amber'],
                                    ['icon' => 'fas fa-chart-pie',       'color' => 'spi-stat-icon-purple'],
                                    ['icon' => 'fas fa-shield-halved',   'color' => 'spi-stat-icon-blue'],
                                    ['icon' => 'fas fa-file-alt',        'color' => 'spi-stat-icon-green'],
                                ];
                            @endphp

                            <div style="display:flex; flex-direction:column; gap:12px;">
                                @foreach ($bidangCounts as $bidang => $count)
                                    @php
                                        $ic = $iconColors[$loop->index % count($iconColors)];
                                    @endphp
                                    <div class="spi-stat-card spi-stagger-item" style="padding:16px 18px;">
                                        <div class="spi-stat-icon {{ $ic['color'] }}">
                                            <i class="{{ $ic['icon'] }}"></i>
                                        </div>
                                        <div class="spi-stat-body" style="flex:1; min-width:0;">
                                            <div class="spi-stat-label">{{ ucfirst($bidang) }}</div>
                                            <div class="spi-stat-value" style="font-size:1.6rem;">{{ $count }}</div>
                                            <div class="spi-stat-meta">Kegiatan aktif</div>
                                        </div>
                                        @if (in_array(auth()->user()->id_level, [1, 2, 3, 4, 6]))
                                            <div style="flex-shrink:0;">
                                                <a href="/posts" class="spi-btn spi-btn-ghost spi-btn-sm">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            {{-- End row --}}

        </div>
    </section>
</div>

<script src="{{ $tugasLaporChart->cdn() }}"></script>
{{ $tugasLaporChart->script() }}
@endsection
