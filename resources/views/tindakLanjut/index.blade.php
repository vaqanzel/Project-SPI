@extends('layout.app')
@section('title', 'Tindak Lanjut')

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
                    <span class="spi-page-breadcrumb-current">Tindak Lanjut</span>
                </div>
                <h1 class="spi-page-title">Tindak Lanjut</h1>
                <p class="spi-page-subtitle">Pantau dan kelola rekomendasi tindak lanjut hasil audit.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Filter Bar ─── --}}
            <div class="spi-card" style="margin-bottom:20px;">
                <div class="spi-card-body" style="padding:16px 24px;">
                    <form action="{{ route('tindak-lanjut.index') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">

                        <div class="spi-search-input" style="min-width:240px;">
                            <i class="fas fa-search"></i>
                            <input type="search"
                                   name="search"
                                   placeholder="Cari judul tindak lanjut..."
                                   value="{{ request('search') }}"
                                   style="border:none; outline:none; flex:1; padding:10px 0; font-size:0.84rem; font-family:inherit; background:transparent; color:#334155;">
                        </div>

                        <select name="year"
                                class="spi-form-control"
                                style="width:auto; min-width:120px; padding:9px 14px;">
                            <option value="">Semua Tahun</option>
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
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>

                        @if (request('search') || request('year'))
                            <a href="{{ route('tindak-lanjut.index') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                <i class="fas fa-times"></i>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- ─── Actions Row ─── --}}
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <div>
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
                        <a href="{{ route('tindak-lanjut.create') }}" class="spi-btn spi-btn-success">
                            <i class="fas fa-plus"></i>
                            Tambah / Edit Rekomendasi
                        </a>
                    @endif
                </div>

                <form action="{{ route('tindak-lanjut.export-excel') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="year" value="{{ request('year') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <button type="submit" class="spi-btn spi-btn-ghost">
                        <i class="fas fa-file-excel" style="color:#10B981;"></i>
                        Export Excel
                    </button>
                </form>
            </div>

            {{-- ─── Main Table Card ─── --}}
            <div class="spi-card">
                <div class="spi-card-header">
                    <div class="spi-card-title">Daftar Tindak Lanjut</div>
                    <span class="spi-badge spi-badge-primary">
                        <i class="fas fa-list-check"></i>
                        Rekomendasi Audit
                    </span>
                </div>

                <div class="spi-table-wrapper" style="border:none; border-radius:0;">
                    <table class="spi-table">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Judul</th>
                                <th class="text-left">Jenis Kegiatan</th>
                                <th colspan="2">Dokumen</th>
                                <th>Waktu Pengumpulan</th>
                                <th class="text-left">Temuan</th>
                                <th class="text-left">Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($posts->currentPage() - 1) * $posts->perPage() + 1; @endphp
                            @forelse ($posts as $post)
                                @php $rtmCount = $post->rtm->count(); @endphp
                                @foreach ($post->rtm as $index => $rtm)
                                    <tr>
                                        @if ($index == 0)
                                            <td class="text-center" rowspan="{{ $rtmCount }}" style="color:#94A3B8; font-size:0.8rem; font-weight:600;">
                                                {{ $no++ }}
                                            </td>
                                        @endif

                                        @if ($index == 0)
                                            <td rowspan="{{ $rtmCount }}">
                                                <div style="font-weight:600; color:#1E293B; font-size:0.84rem;">{{ $post->judul_tindak_lanjut }}</div>
                                            </td>
                                        @endif

                                        @if ($index == 0)
                                            <td rowspan="{{ $rtmCount }}">
                                                <span class="spi-badge spi-badge-info">{{ $post->jenis_kegiatan }}</span>
                                            </td>
                                        @endif

                                        @if ($index == 0)
                                            <td rowspan="{{ $rtmCount }}" style="font-size:0.82rem; color:#475569;">
                                                {{ $post->dokumen_tindak_lanjut }}
                                            </td>
                                        @endif

                                        @if ($index == 0)
                                            <td rowspan="{{ $rtmCount }}" class="text-center">
                                                <a href="{{ asset('dokumen_tindaklanjut/' . $post->dokumen_tindak_lanjut) }}"
                                                   target="_blank"
                                                   class="spi-btn spi-btn-outline spi-btn-icon-sm"
                                                   title="Buka Dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        @endif

                                        @if ($index == 0)
                                            <td class="text-center" rowspan="{{ $rtmCount }}">
                                                <div style="font-size:0.82rem; color:#475569; white-space:nowrap;">
                                                    {{ \Carbon\Carbon::parse($post['tindakLanjut_at'])->format('d F Y') }}
                                                </div>
                                            </td>
                                        @endif

                                        <td style="font-size:0.82rem; color:#334155; max-width:200px;">{{ $rtm->temuan }}</td>
                                        <td style="font-size:0.82rem; color:#334155; max-width:220px;">{{ $rtm->rekomendasi }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="spi-empty-state">
                                            <div class="spi-empty-state-icon">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="spi-empty-state-title">Data Dokumen Belum Tersedia</div>
                                            <div class="spi-empty-state-text">
                                                Belum ada data tindak lanjut yang sesuai dengan filter yang dipilih.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div style="padding:16px 24px;">
                        {{ $posts->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>
            {{-- end spi-card --}}

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
@endsection
