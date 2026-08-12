@extends('layout.app')
@section('title', 'Berita Acara')

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
                    <span class="spi-page-breadcrumb-current">Berita Acara</span>
                </div>
                <h1 class="spi-page-title">Berita Acara</h1>
                <p class="spi-page-subtitle">Kelola notulen rapat beserta dokumen dan galeri pendukung kegiatan.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ route('berita-acara.create') }}" class="spi-btn spi-btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Berita Acara
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Alert ─── --}}
            @if (session('success'))
                <div class="spi-alert spi-alert-success" id="spi-alert-success">
                    <i class="fas fa-check-circle spi-alert-icon"></i>
                    <div class="spi-alert-body">{{ session('success') }}</div>
                    <button class="spi-alert-close" onclick="this.closest('.spi-alert').remove();">&times;</button>
                </div>
            @endif

            {{-- ─── Main Card ─── --}}
            <div class="spi-card">

                {{-- Card Header: Search + Stats --}}
                <div class="spi-card-header" style="flex-wrap:wrap; gap:12px;">
                    <div>
                        <div class="spi-card-title">Daftar Berita Acara</div>
                        <div class="spi-card-subtitle">Total {{ $minutes->total() }} berita acara ditemukan</div>
                    </div>

                    {{-- Search Form --}}
                    <form method="GET" action="{{ route('berita-acara.index') }}" class="d-flex align-items-center" style="gap:8px;">
                        <div class="spi-search-input" style="min-width:260px;">
                            <i class="fas fa-search"></i>
                            <input type="search" name="search"
                                   placeholder="Cari judul, lokasi, atau ringkasan..."
                                   value="{{ $search }}"
                                   style="border:none; outline:none; flex:1; padding:10px 0; font-size:0.84rem; font-family:inherit; background:transparent; color:#334155;">
                        </div>
                        <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('berita-acara.index') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                <i class="fas fa-times"></i>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- ─── Table ─── --}}
                <div class="spi-table-wrapper" style="border:none; border-radius:0;">
                    <table class="spi-table">
                        <thead>
                            <tr>
                                <th style="width:5%;">No</th>
                                <th>Judul &amp; Ringkasan</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th class="text-center">Dokumen</th>
                                <th class="text-center">Gambar</th>
                                <th>Diperbarui</th>
                                <th class="text-center" style="width:130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($minutes as $minute)
                                <tr>
                                    <td style="color:#94A3B8; font-size:0.8rem;">
                                        {{ ($minutes->currentPage() - 1) * $minutes->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <div style="font-weight:600; color:#1E293B; font-size:0.875rem; line-height:1.3;">{{ $minute->title }}</div>
                                        @if ($minute->summary)
                                            <div style="font-size:0.78rem; color:#94A3B8; margin-top:3px; line-height:1.4;">
                                                {{ \Illuminate\Support\Str::limit($minute->summary, 80) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size:0.84rem; font-weight:500; color:#334155;">
                                            {{ optional($minute->meeting_date)->format('d M Y') ?? '—' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size:0.84rem; color:#475569;">
                                            {{ $minute->location ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="spi-badge spi-badge-primary">
                                            <i class="fas fa-file"></i>
                                            {{ $minute->documents_count }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="spi-badge spi-badge-info">
                                            <i class="fas fa-image"></i>
                                            {{ $minute->images_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size:0.78rem; color:#94A3B8;">{{ $minute->updated_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                            <a href="{{ route('berita-acara.edit', $minute) }}"
                                               class="spi-btn spi-btn-warning spi-btn-icon-sm"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('berita-acara.destroy', $minute) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus berita acara ini? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="spi-btn spi-btn-danger spi-btn-icon-sm"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="spi-empty-state">
                                            <div class="spi-empty-state-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="spi-empty-state-title">Belum ada berita acara</div>
                                            <div class="spi-empty-state-text">
                                                @if ($search)
                                                    Tidak ada hasil untuk pencarian "<strong>{{ $search }}</strong>".
                                                    <a href="{{ route('berita-acara.index') }}">Reset pencarian</a>
                                                @else
                                                    Klik tombol <strong>Tambah Berita Acara</strong> untuk membuat berita acara pertama.
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($minutes->hasPages())
                    <div style="padding:16px 24px;">
                        {{ $minutes->links() }}
                    </div>
                @endif

            </div>
            {{-- end spi-card --}}

        </div>
    </section>
</div>
@endsection
