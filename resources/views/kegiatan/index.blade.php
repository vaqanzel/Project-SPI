@extends('layout.app')
@section('title', 'Master Kegiatan')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')

{{-- ════════════════════════════════════════════════════════════════
     MODAL: Tambah Kegiatan
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="uploadModal" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('kegiatan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">
                        <i class="fas fa-plus" style="color:#173F9E; margin-right:8px;"></i>
                        Tambah Kegiatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">UNIT KERJA</label>
                        <select class="select2 form-control @error('id_unit_kerja') is-invalid @enderror"
                            name="id_unit_kerja" data-placeholder="Pilih Unit Kerja">
                            <option></option>
                            @foreach ($unitKerjas as $unitKerja)
                                <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit_kerja }}</option>
                            @endforeach
                        </select>
                        @error('id_unit_kerja')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">JUDUL KEGIATAN</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Kegiatan">
                        @error('judul')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">IKU</label>
                        <input type="text" class="form-control @error('iku') is-invalid @enderror" name="iku"
                            value="{{ old('iku') }}" placeholder="Masukkan IKU...">
                        @error('iku')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">SASARAN STRATEGIS</label>
                        <select class="form-control @error('sasaran') is-invalid @enderror" name="sasaran">
                            <option value="" disabled selected>Pilih Sasaran</option>
                            <option value="1. Meningkatnya kualitas lulusan pendidikan tinggi"
                                {{ old('kategori') == 1 ? 'selected' : '' }}>1. Meningkatnya kualitas lulusan pendidikan tinggi</option>
                            <option value="2. Meningkatnya kualitas dosen pendidikan tinggi"
                                {{ old('kategori') == 2 ? 'selected' : '' }}>2. Meningkatnya kualitas dosen pendidikan tinggi</option>
                            <option value="3. Meningkatnya kualitas kurikulum dan pembelajaran"
                                {{ old('kategori') == 3 ? 'selected' : '' }}>3. Meningkatnya kualitas kurikulum dan pembelajaran</option>
                            <option value="4. Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi"
                                {{ old('kategori') == 4 ? 'selected' : '' }}>4. Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi</option>
                        </select>
                        @error('sasaran')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">PROGRAM KERJA</label>
                        <input type="text" class="form-control @error('proker') is-invalid @enderror" name="proker"
                            value="{{ old('proker') }}" placeholder="Masukkan Program Kerja...">
                        @error('proker')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">INDIKATOR</label>
                        <input type="text" class="form-control @error('indikator') is-invalid @enderror"
                            name="indikator" value="{{ old('indikator') }}" placeholder="Masukkan Indikator...">
                        @error('indikator')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">ANGGARAN</label>
                        <input type="text" class="form-control @error('anggaran') is-invalid @enderror"
                            name="anggaran" value="{{ old('anggaran') }}" placeholder="Masukkan Anggaran...">
                        @error('anggaran')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                        <i class="fas fa-save"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
     MODAL: Hapus Data Berdasarkan Tahun
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="deleteYearModal" tabindex="-1" aria-labelledby="deleteYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kegiatan.deleteByYear') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteYearModalLabel">
                        <i class="fas fa-trash" style="color:#EF4444; margin-right:8px;"></i>
                        Hapus Data Kegiatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="year" class="form-label">Pilih Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" required
                            min="2000" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}">
                    </div>
                    <div class="spi-alert spi-alert-warning">
                        <i class="fas fa-exclamation-triangle spi-alert-icon"></i>
                        <div class="spi-alert-body">
                            <div class="spi-alert-title">Perhatian!</div>
                            Tindakan ini akan menghapus semua data kegiatan pada tahun yang dipilih dan <strong>tidak dapat dibatalkan</strong>.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="spi-btn spi-btn-danger spi-btn-sm" id="confirmDelete">
                        <i class="fas fa-trash"></i> Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
     MODAL: Import Data Excel
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kegiatan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="fas fa-file-excel" style="color:#10B981; margin-right:8px;"></i>
                        Import Data Kegiatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih file Excel</label>
                        <input type="file" name="file" class="form-control" required>
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
     MODALS: Edit per Kegiatan
════════════════════════════════════════════════════════════════ --}}
@foreach ($kegiatans as $kegiatan)
<div class="modal fade" id="editModal{{ $kegiatan->id }}" tabindex="-1"
    aria-labelledby="editModal{{ $kegiatan->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal{{ $kegiatan->id }}">
                        <i class="fas fa-edit" style="color:#F59E0B; margin-right:8px;"></i>
                        Edit Kegiatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">UNIT KERJA</label>
                        <select class="select2 form-control @error('id_unit_kerja') is-invalid @enderror"
                            name="id_unit_kerja" data-placeholder="Pilih Unit Kerja">
                            @foreach ($unitKerjas as $unitKerja)
                                <option value="{{ $unitKerja->id }}"
                                    {{ $kegiatan->id_unit_kerja == $unitKerja->id ? 'selected' : '' }}>
                                    {{ $unitKerja->nama_unit_kerja }}</option>
                            @endforeach
                        </select>
                        @error('id_unit_kerja')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">JUDUL KEGIATAN</label>
                        <input type="text" class="form-control" name="judul"
                            placeholder="Masukkan Judul Kegiatan" value="{{ $kegiatan->judul }}">
                        @error('judul')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">IKU</label>
                        <input type="text" class="form-control @error('iku') is-invalid @enderror"
                            name="iku" value="{{ $kegiatan->iku }}" placeholder="Masukkan IKU...">
                        @error('iku')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">SASARAN STRATEGIS</label>
                        <select class="form-control @error('sasaran') is-invalid @enderror" name="sasaran">
                            <option value="" disabled>Pilih Sasaran</option>
                            <option value="1. Meningkatnya kualitas lulusan pendidikan tinggi"
                                {{ $kegiatan->sasaran == '1. Meningkatnya kualitas lulusan pendidikan tinggi' ? 'selected' : '' }}>
                                1. Meningkatnya kualitas lulusan pendidikan tinggi</option>
                            <option value="2. Meningkatnya kualitas dosen pendidikan tinggi"
                                {{ $kegiatan->sasaran == '2. Meningkatnya kualitas dosen pendidikan' ? 'selected' : '' }}>
                                2. Meningkatnya kualitas dosen pendidikan tinggi</option>
                            <option value="3. Meningkatnya kualitas kurikulum dan pembelajaran"
                                {{ $kegiatan->sasaran == '3. Meningkatnya kualitas kurikulum dan pembelajaran' ? 'selected' : '' }}>
                                3. Meningkatnya kualitas kurikulum dan pembelajaran</option>
                            <option value="4. Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi"
                                {{ $kegiatan->sasaran == '4. Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi' ? 'selected' : '' }}>
                                4. Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi</option>
                        </select>
                        @error('sasaran')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">PROGRAM KERJA</label>
                        <input type="text" class="form-control @error('proker') is-invalid @enderror"
                            name="proker" value="{{ $kegiatan->proker }}" placeholder="Masukkan Program Kerja...">
                        @error('proker')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">INDIKATOR</label>
                        <input type="text" class="form-control @error('indikator') is-invalid @enderror"
                            name="indikator" value="{{ $kegiatan->indikator }}" placeholder="Masukkan Indikator...">
                        @error('indikator')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">ANGGARAN</label>
                        <input type="text" class="form-control @error('anggaran') is-invalid @enderror"
                            name="anggaran" value="{{ $kegiatan->anggaran }}" placeholder="Masukkan Anggaran...">
                        @error('anggaran')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
                    <span class="spi-page-breadcrumb-current">Master Kegiatan</span>
                </div>
                <h1 class="spi-page-title">Master Kegiatan</h1>
                <p class="spi-page-subtitle">Kelola seluruh kegiatan pengawasan internal berdasarkan unit kerja dan bidang.</p>
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
                    <form action="{{ route('kegiatan.index') }}" method="GET"
                          style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">

                        <div class="spi-search-input" style="min-width:240px;">
                            <i class="fas fa-search"></i>
                            <input type="search" name="search"
                                   placeholder="Cari judul kegiatan..."
                                   value="{{ request('search') }}"
                                   style="border:none; outline:none; flex:1; padding:10px 0; font-size:0.84rem; font-family:inherit; background:transparent; color:#334155;">
                        </div>

                        <select name="year" class="spi-form-control" style="width:auto; min-width:120px; padding:9px 14px;">
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
                            <a href="{{ route('kegiatan.index') }}" class="spi-btn spi-btn-ghost spi-btn-sm">
                                <i class="fas fa-times"></i>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- ─── Actions Row ─── --}}
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                        <a href="{{ route('posts.index') }}"
                           data-toggle="modal" data-target="#uploadModal"
                           class="spi-btn spi-btn-primary spi-btn-sm">
                            <i class="fas fa-plus"></i>
                            Tambah Kegiatan
                        </a>
                        <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm"
                                data-toggle="modal" data-target="#importModal">
                            <i class="fas fa-file-excel" style="color:#10B981;"></i>
                            Import Excel
                        </button>
                        <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm"
                                data-toggle="modal" data-target="#deleteYearModal">
                            <i class="fas fa-trash" style="color:#EF4444;"></i>
                            Hapus Per Tahun
                        </button>
                    @endif
                </div>
                <button id="exportExcelButton" class="spi-btn spi-btn-ghost spi-btn-sm">
                    <i class="fas fa-file-excel" style="color:#10B981;"></i>
                    Export Excel
                </button>
            </div>

            {{-- ─── Main Table Card ─── --}}
            <div class="spi-card">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">Daftar Master Kegiatan</div>
                        <div class="spi-card-subtitle">
                            Halaman {{ $kegiatans->currentPage() }} dari {{ $kegiatans->lastPage() }} —
                            Total {{ $kegiatans->total() }} kegiatan
                        </div>
                    </div>
                    <span class="spi-badge spi-badge-primary">
                        <i class="fas fa-list-check"></i>
                        Kegiatan Aktif
                    </span>
                </div>

                <div class="spi-table-wrapper" style="border:none; border-radius:0;">
                    <table class="spi-table" id="tableKegiatan">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Judul</th>
                                @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                    <th class="text-left">Unit Kerja</th>
                                @endif
                                <th class="text-left">IKU</th>
                                <th class="text-left">Sasaran</th>
                                <th class="text-left">Proker</th>
                                <th class="text-left">Indikator</th>
                                <th class="text-left">Anggaran</th>
                                <th>Tanggal</th>
                                @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                    <th class="text-center" colspan="2">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + 1; @endphp
                            @forelse ($kegiatans as $kegiatan)
                                <tr>
                                    <td class="text-center" style="color:#94A3B8; font-size:0.8rem;">{{ $no++ }}</td>
                                    <td>
                                        <div style="font-weight:600; color:#1E293B; font-size:0.84rem;">{{ $kegiatan->judul }}</div>
                                    </td>
                                    @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                        <td>
                                            <span class="spi-badge spi-badge-info">{{ $kegiatan->unitKerja->nama_unit_kerja }}</span>
                                        </td>
                                    @endif
                                    <td style="font-size:0.82rem; color:#475569; max-width:150px;">{{ $kegiatan->iku }}</td>
                                    <td style="font-size:0.78rem; color:#475569; max-width:180px; line-height:1.4;">{{ $kegiatan->sasaran }}</td>
                                    <td style="font-size:0.82rem; color:#475569;">{{ $kegiatan->proker }}</td>
                                    <td style="font-size:0.82rem; color:#475569;">{{ $kegiatan->indikator }}</td>
                                    <td style="font-size:0.82rem; color:#475569;">{{ $kegiatan->anggaran }}</td>
                                    <td class="text-center" style="font-size:0.78rem; color:#94A3B8; white-space:nowrap;">
                                        {{ \Carbon\Carbon::parse($kegiatan['updated_at'])->format('d M Y') }}
                                    </td>
                                    @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                        <td class="text-center">
                                            <button class="spi-btn spi-btn-warning spi-btn-icon-sm"
                                                    data-toggle="modal"
                                                    data-target="#editModal{{ $kegiatan->id }}"
                                                    title="Edit">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus kegiatan ini?');"
                                                action="{{ route('kegiatan.destroy', $kegiatan) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="spi-btn spi-btn-danger spi-btn-icon-sm"
                                                    title="Hapus Kegiatan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ (auth()->user()->id_level == 1 || auth()->user()->id_level == 2) ? 11 : 9 }}">
                                        <div class="spi-empty-state">
                                            <div class="spi-empty-state-icon">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <div class="spi-empty-state-title">Data Kegiatan Belum Tersedia</div>
                                            <div class="spi-empty-state-text">Belum ada data kegiatan yang sesuai dengan filter yang dipilih.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kegiatans->hasPages())
                    <div style="padding:16px 24px;">
                        {{ $kegiatans->links('pagination::bootstrap-4') }}
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
    // Toastr flash messages
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif

    // Confirm delete year
    document.getElementById('confirmDelete').addEventListener('click', function(e) {
        e.preventDefault();
        const year = document.getElementById('year').value;
        if (confirm(`Anda yakin ingin menghapus semua data kegiatan tahun ${year}?`)) {
            this.closest('form').submit();
        }
    });

    // Export Excel
    function exportTableToExcel(tableId, filename = 'Master Kegiatan.xlsx') {
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.table_to_sheet(document.getElementById(tableId));
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, filename);
    }

    document.getElementById('exportExcelButton').addEventListener('click', function() {
        exportTableToExcel('tableKegiatan');
    });
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#uploadModal'),
            width: '100%',
            placeholder: 'Pilih Unit Kerja',
            allowClear: true,
            matcher: function(params, data) {
                if ($.trim(params.term) === '') return data;
                if (typeof data.text === 'undefined') return null;
                var term = params.term.toLowerCase();
                var text = data.text.toLowerCase();
                if (text.indexOf(term) > -1) return data;
                return null;
            }
        });
    });
</script>
@endpush

@endsection
