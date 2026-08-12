@extends('layout.app')
@section('title', 'PIC Kegiatan')
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
                    <span class="spi-page-breadcrumb-current">PIC Kegiatan</span>
                </div>
                <h1 class="spi-page-title">PIC Kegiatan</h1>
                <p class="spi-page-subtitle">Kelola dan pantau semua kegiatan penugasan audit.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Tabel Pending (untuk Level 1 & 3) ─── --}}
            @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 3)
            <div class="spi-card" style="margin-bottom:20px;">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">List Tugas Untuk Disetujui</div>
                        <div class="spi-card-subtitle">Tugas yang menunggu persetujuan Anda.</div>
                    </div>
                    <span class="spi-badge spi-badge-warning">
                        <i class="fas fa-clock"></i>
                        Pending Approval
                    </span>
                </div>
                <div class="spi-card-body">
                    <div class="spi-table-container">
                        <table class="spi-table" id="tablePending">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Tempat</th>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>PIC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingPosts as $post)
                                    <tr>
                                        <td>{{ $post->waktu }}</td>
                                        <td>{{ $post->tempat }}</td>
                                        <td>{{ $jenisKegiatan[$post->jenis]->jenis ?? 'N/A' }}</td>
                                        <td>{{ $post->judul }}</td>
                                        <td>{{ $post->deskripsi }}</td>
                                        <td>
                                            <span class="spi-badge spi-badge-primary">{{ $post->tanggungjawab }}</span>
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:6px; align-items:center;">
                                                <a href="/detailTugas/{{ $post->id }}"
                                                   class="spi-btn spi-btn-icon-sm spi-btn-success"
                                                   title="Detail Tugas">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <form action="{{ route('posts.approve_task', $post->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="spi-btn spi-btn-icon-sm spi-btn-primary" title="Approve Tugas">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('posts.disapprove_task', $post->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="spi-btn spi-btn-icon-sm spi-btn-danger" title="Disapprove Tugas">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding:40px;">
                                            <div style="color:#94A3B8; font-size:0.875rem;">
                                                <i class="fas fa-inbox" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                                Tidak ada tugas yang menunggu persetujuan.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $pendingPosts->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif

            {{-- ─── Search ─── --}}
            <div class="spi-card">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">List Tugas</div>
                        <div class="spi-card-subtitle">Seluruh kegiatan penugasan audit yang telah disetujui.</div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                            <a href="{{ route('posts.create') }}" class="spi-btn spi-btn-primary spi-btn-sm">
                                <i class="fas fa-plus"></i> Tambah Tugas
                            </a>
                        @endif
                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2 || auth()->user()->id_level == 3 || auth()->user()->id_level == 6)
                            <a href="{{ route('reviewKetua') }}" class="spi-btn spi-btn-outline spi-btn-sm">Approve Kegiatan</a>
                        @endif
                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2 || auth()->user()->id_level == 3 || auth()->user()->id_level == 4 || auth()->user()->id_level == 6)
                            <a href="{{ route('laporanAkhir') }}" class="spi-btn spi-btn-outline spi-btn-sm">Laporan Akhir</a>
                        @endif
                        <a href="{{ route('dokumenTindakLanjut') }}" class="spi-btn spi-btn-outline spi-btn-sm">Dokumen Tindak Lanjut</a>
                        <button id="exportExcelButton" class="spi-btn spi-btn-success spi-btn-sm">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                    </div>
                </div>

                <div class="spi-card-body">
                    {{-- Search Form --}}
                    <form action="{{ route('posts.index') }}" method="GET" style="margin-bottom:16px;">
                        <div style="display:flex; gap:10px; align-items:center;">
                            <div class="spi-search-wrap" style="flex:1; max-width:380px;">
                                <i class="fas fa-search spi-search-icon"></i>
                                <input type="search" name="search" class="spi-search-input"
                                    placeholder="Search: Masukkan Judul / Waktu / PIC"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    <div class="spi-table-container">
                        <table class="spi-table" id="tableKegiatan">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Tempat</th>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>PIC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedPosts as $post)
                                    <tr>
                                        <td>{{ $post->waktu }}</td>
                                        <td>{{ $post->tempat }}</td>
                                        <td>{{ $jenisKegiatan[$post->jenis]->jenis ?? 'N/A' }}</td>
                                        <td>{{ $post->judul }}</td>
                                        <td>{{ $post->deskripsi }}</td>
                                        <td>
                                            <span class="spi-badge spi-badge-primary">{{ $post->tanggungjawab }}</span>
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:6px; align-items:center;">
                                                @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2 || auth()->user()->id_level == 3 || auth()->user()->id_level == 4 || auth()->user()->id_level == 6)
                                                    <a href="/detailTugas/{{ $post->id }}"
                                                       class="spi-btn spi-btn-icon-sm spi-btn-success"
                                                       title="Detail Tugas">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                @endif
                                                @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                                    <a href="/tampilData/{{ $post->id }}"
                                                       class="spi-btn spi-btn-icon-sm"
                                                       title="Edit Tugas"
                                                       style="background:#FEF3C7; color:#92400E; border-color:#FDE68A;">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                          action="{{ route('posts.destroy', $post->id) }}"
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="spi-btn spi-btn-icon-sm spi-btn-danger" title="Hapus Tugas">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding:40px;">
                                            <div style="color:#94A3B8; font-size:0.875rem;">
                                                <i class="fas fa-inbox" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                                Data Post belum Tersedia.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $approvedPosts->links('pagination::bootstrap-4') }}
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

    function exportTableToExcel(tableId, filename = 'Kegiatan.xlsx') {
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.table_to_sheet(document.getElementById(tableId));
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, filename);
    }

    document.getElementById('exportExcelButton').addEventListener('click', function() {
        exportTableToExcel('tableKegiatan');
    });
</script>
@endpush
@endsection
