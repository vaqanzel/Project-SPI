@extends('layout.app')
@section('title', 'Peta Risiko')

@section('main')

{{-- ════════════════════════════════════════════════════════════════
     MODAL: Import Excel Peta Risiko (TIDAK DIUBAH - semua logic backend dipertahankan)
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('peta.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="fas fa-file-excel" style="color:#10B981; margin-right:8px;"></i>
                        Import Data Peta Risiko
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih file Excel</label>
                        <input type="file" name="file" class="form-control" required accept=".xls, .xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                        <i class="fas fa-upload"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════════════════════════ --}}
<div class="main-content">
    <section class="section">

        {{-- ─── Page Header ─── --}}
        <div class="spi-page-header">
            <div class="spi-page-header-left">
                <div class="spi-page-breadcrumb">
                    <i class="fas fa-home" style="font-size:0.7rem;"></i>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="spi-page-breadcrumb-current">Peta Risiko</span>
                </div>
                <h1 class="spi-page-title">Peta Risiko</h1>
                <p class="spi-page-subtitle">Pantau dan analisis peta risiko pengawasan internal per unit kerja.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Rekapitulasi Summary Cards ─── --}}
            <div class="spi-stats-row" style="grid-template-columns: repeat(2, 1fr); max-width:600px; margin-bottom:24px;">
                <div class="spi-stat-card spi-stagger-item">
                    <div class="spi-stat-icon spi-stat-icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="spi-stat-body">
                        <div class="spi-stat-label">Disetujui</div>
                        <div class="spi-stat-value">{{ $approvedCount }}</div>
                        <div class="spi-stat-meta">Dokumen disetujui</div>
                    </div>
                </div>
                <div class="spi-stat-card spi-stagger-item">
                    <div class="spi-stat-icon spi-stat-icon-red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="spi-stat-body">
                        <div class="spi-stat-label">Ditolak</div>
                        <div class="spi-stat-value">{{ $rejectedCount }}</div>
                        <div class="spi-stat-meta">Dokumen ditolak</div>
                    </div>
                </div>
            </div>

            {{-- ─── Search & Filter Bar ─── --}}
            <div class="spi-card" style="margin-bottom:20px;">
                <div class="spi-card-body" style="padding:16px 24px;">
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        {{-- Search --}}
                        <form action="{{ route('petaRisiko.search') }}" method="GET" style="display:flex; gap:8px; align-items:center; flex:1; min-width:200px;">
                            <div class="spi-search-input" style="min-width:240px;">
                                <i class="fas fa-search"></i>
                                <input type="search" name="search"
                                       placeholder="Cari judul atau tahun..."
                                       style="border:none; outline:none; flex:1; padding:10px 0; font-size:0.84rem; font-family:inherit; background:transparent; color:#334155;">
                            </div>
                            <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                                <i class="fas fa-search"></i>
                                Cari
                            </button>
                        </form>

                        {{-- Actions --}}
                        <div style="display:flex; gap:8px; flex-wrap:wrap; flex-shrink:0;">
                            <a href="{{ route('petas.tabel') }}" class="spi-btn spi-btn-outline spi-btn-sm">
                                <i class="fas fa-table"></i>
                                Tabel Matrik
                            </a>
                            @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                <a href="{{ route('imported-excel.index') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                    <i class="fas fa-file-excel" style="color:#10B981;"></i>
                                    Import Excel
                                </a>
                                <a href="{{ route('peta.penelaah') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                    <i class="fas fa-user-check"></i>
                                    Tambah Penelaah
                                </a>
                                <a href="{{ route('peta.export-excel') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                    <i class="fas fa-download" style="color:#10B981;"></i>
                                    Export Excel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Main Table Card ─── --}}
            <div class="spi-card" style="margin-bottom:24px;">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">Daftar Peta Risiko</div>
                        <div class="spi-card-subtitle">Data dokumen peta risiko per unit kerja</div>
                    </div>
                    <span class="spi-badge spi-badge-warning">
                        <i class="fas fa-triangle-exclamation"></i>
                        Risk Map
                    </span>
                </div>

                <div class="spi-table-wrapper" style="border:none; border-radius:0;">
                    <table class="spi-table">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Unit Kerja</th>
                                <th>Kegiatan</th>
                                <th class="text-left">Penelaah</th>
                                <th>Tahun</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Tabel Matrik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($jenisCount->currentPage() - 1) * $jenisCount->perPage() + 1; @endphp
                            @forelse ($jenisCount as $item)
                                <tr>
                                    <td class="text-center" style="color:#94A3B8; font-size:0.8rem;">{{ $no++ }}</td>
                                    <td style="font-weight:600; color:#1E293B; font-size:0.84rem;">{{ $item->jenis }}</td>
                                    <td class="text-center">
                                        <span class="spi-badge spi-badge-primary">{{ $item->total }}</span>
                                    </td>
                                    <td style="font-size:0.82rem; color:#475569;">{{ $item->penelaah }}</td>
                                    <td class="text-center">
                                        <span class="spi-badge spi-badge-gray">
                                            {{ \Carbon\Carbon::parse($item->tahun)->format('Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('petaRisikoDetail', $item->jenis) }}"
                                           class="spi-btn spi-btn-success spi-btn-sm">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('petas.tabelUnitKerja', ['unitKerja' => $item->jenis]) }}"
                                           class="spi-btn spi-btn-outline spi-btn-icon-sm"
                                           title="Lihat Tabel Matrik Unit Kerja">
                                            <i class="fas fa-table"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="spi-empty-state">
                                            <div class="spi-empty-state-icon">
                                                <i class="fas fa-map"></i>
                                            </div>
                                            <div class="spi-empty-state-title">Data Peta Risiko Belum Tersedia</div>
                                            <div class="spi-empty-state-text">Belum ada data peta risiko yang terdaftar dalam sistem.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($jenisCount->hasPages())
                    <div style="padding:16px 24px;">
                        {{ $jenisCount->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>

            {{-- ─── Year Filter + Chart ─── --}}
            <div class="spi-card" style="margin-bottom:24px;">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">Grafik Skor Pengaruh Kegiatan</div>
                        <div class="spi-card-subtitle">Tahun {{ $selectedYear }} — Total kegiatan pengaruh tinggi: <strong>{{ $totalHighImpactActivities }}</strong></div>
                    </div>

                    {{-- Year Filter --}}
                    <form action="{{ route('petas.index') }}" method="GET" style="display:flex; gap:8px; align-items:center;">
                        <select name="year" class="spi-form-control" style="width:auto; min-width:100px; padding:8px 12px; font-size:0.84rem;">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                    </form>
                </div>

                <div class="spi-card-body">
                    <div style="height:400px; overflow-x:auto;">
                        <canvas id="highImpactChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('highImpactChart').getContext('2d');
        var chartData = @json($chartData);
        var chart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Skor Pengaruh' }
                    },
                    x: {
                        title: { display: true, text: 'Id Kegiatan' },
                        ticks: { maxRotation: 0, minRotation: 0 }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Grafik Pengaruh Kegiatan Tahun {{ $selectedYear }}'
                    }
                }
            }
        });
    });
</script>
@endpush

@endsection
