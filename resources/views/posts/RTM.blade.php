@extends('layout.app')
@section('title', 'Dokumen RTM')
@section('main')
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
                    <span class="spi-page-breadcrumb-current">Dokumen RTM</span>
                </div>
                <h1 class="spi-page-title">Dokumen RTM</h1>
                <p class="spi-page-subtitle">Rekap Temuan dan Monitoring tindak lanjut hasil audit.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">
            <div class="spi-card">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">List Kegiatan</div>
                        <div class="spi-card-subtitle">Semua kegiatan audit beserta rekomendasi dan status tindak lanjut.</div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        @php
                            $showButton = false;
                            foreach ($pic as $item) {
                                if (
                                    $item->tanggungjawab == auth()->user()->name &&
                                    !in_array($item->id_level, [1, 2, 3, 6])
                                ) {
                                    $showButton = true;
                                    break;
                                }
                            }
                            if (!$showButton && in_array(auth()->user()->id_level, [1, 2, 3, 6])) {
                                $showButton = true;
                            }
                        @endphp
                        @if ($showButton)
                            <a href="{{ route('rtm.create') }}" class="spi-btn spi-btn-primary spi-btn-sm">
                                <i class="fas fa-plus"></i> Tambah/Edit RTM
                            </a>
                        @endif
                        <a href="{{ route('rtm.export-excel', ['year' => request('year'), 'search' => request('search')]) }}"
                           class="spi-btn spi-btn-success spi-btn-sm">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                </div>

                <div class="spi-card-body">
                    {{-- Search & Filter --}}
                    <form action="{{ route('rtm') }}" method="GET" style="margin-bottom:16px;">
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                            <div class="spi-search-wrap" style="flex:1; min-width:200px; max-width:320px;">
                                <i class="fas fa-search spi-search-icon"></i>
                                <input type="search" name="search" class="spi-search-input"
                                    placeholder="Search: Masukkan Judul"
                                    value="{{ request('search') }}">
                            </div>
                            <select name="year" class="spi-form-control spi-form-select" style="width:160px; height:40px; padding:0 12px;">
                                <option value="">Pilih Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2020;
                                @endphp
                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            @if (request('search') || request('year'))
                                <a href="{{ route('rtm') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                    <i class="fas fa-rotate-left"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="spi-table-container">
                        <table class="spi-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>PIC</th>
                                    <th>Rekomendasi</th>
                                    <th>Rencana Tindak Lanjut</th>
                                    <th>Rencana Waktu Tindak Lanjut</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($posts->currentPage() - 1) * $posts->perPage() + 1; @endphp
                                @forelse ($posts as $post)
                                    @php $rtmCount = $post->rtm->count(); @endphp
                                    @foreach ($post->rtm as $index => $rtm)
                                        <tr>
                                            @if ($index == 0)
                                                <td rowspan="{{ $rtmCount }}" style="text-align:center; font-weight:600; color:#64748B;">
                                                    {{ $no++ }}
                                                </td>
                                            @endif
                                            @if ($index == 0)
                                                <td rowspan="{{ $rtmCount }}" style="font-weight:500; color:#1E293B;">
                                                    {{ $post->judul }}
                                                </td>
                                            @endif
                                            <td>
                                                @if ($rtm->pic_rtm->isEmpty())
                                                    <span class="spi-badge" style="background:#F1F5F9; color:#94A3B8;">-</span>
                                                @else
                                                    @foreach ($rtm->pic_rtm as $pic)
                                                        <span class="spi-badge spi-badge-primary">
                                                            {{ $pic->unitKerja->nama_unit_kerja }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td style="font-size:0.85rem;">{{ $rtm->rekomendasi }}</td>
                                            <td style="font-size:0.85rem;">{{ $rtm->rencanaTinJut }}</td>
                                            <td style="text-align:center; font-size:0.83rem;">
                                                @if ($rtm->rencanaWaktuTinJut)
                                                    {{ \Carbon\Carbon::parse($rtm->rencanaWaktuTinJut)->format('d F Y') }}
                                                @else
                                                    <span style="color:#CBD5E1;">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($rtm->status_rtm == 'Open')
                                                    <span class="spi-badge spi-badge-success">Open</span>
                                                @elseif($rtm->status_rtm == 'Closed')
                                                    <span class="spi-badge spi-badge-danger">Closed</span>
                                                @else
                                                    <span class="spi-badge spi-badge-warning">In Progress</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding:50px 20px;">
                                            <div style="color:#94A3B8; font-size:0.875rem;">
                                                <i class="fas fa-inbox" style="font-size:2rem; display:block; margin-bottom:10px; opacity:0.4;"></i>
                                                Data Dokumen belum Tersedia.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>
@endpush
@endsection
