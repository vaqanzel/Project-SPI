@extends('layout.app')
@section('title', 'Template Dokumen')

@section('main')

@php
    $defaultKeterangan = [
        'Template Dokumen Reviu',
        'Template Berita Acara',
        'Template Lembar Pengesahan',
        'Template Kertas Kerja',
        'Template Dokumen Tindak Lanjut',
        'Dokumen Peraturan',
    ];
@endphp

{{-- ════════════════════════════════════════════════════════════════
     MODALS: Edit & Upload per Jenis & Index (semua logika PHP dipertahankan)
════════════════════════════════════════════════════════════════ --}}
@foreach ($jenisDokumen as $jenis)
    @php
        $documents = $jenis->templateDokumen;
        $filteredKeterangan = [];
        if ($jenis->id == 1) {
            $filteredKeterangan = [$defaultKeterangan[4]];
        } elseif ($jenis->id == 2) {
            $filteredKeterangan = array_slice($defaultKeterangan, 0, 5);
        } elseif ($jenis->id == 3) {
            $filteredKeterangan = [$defaultKeterangan[5]];
        }
        $rowCount = count($filteredKeterangan);
    @endphp

    @for ($index = 0; $index < $rowCount; $index++)
        @php
            $keterangan = $filteredKeterangan[$index];

            $acceptTypes = '.doc,.docx';
            $fileTypeInfo = 'Format file yang diperbolehkan: DOC, DOCX, ukuran maksimal 10MB *';

            if ($keterangan == 'Template Kertas Kerja') {
                $acceptTypes = '.xls,.xlsx';
                $fileTypeInfo = 'Format file yang diperbolehkan: XLS, XLSX, ukuran maksimal 10MB *';
            }

            if ($documents == null) {
                $document = null;
            } else {
                $document = $documents->firstWhere('judul', $keterangan);
            }
        @endphp

        @if ($document)
            {{-- Edit Modal --}}
            <div class="modal fade" id="editTemplateDokumenModal{{ $jenis->id }}{{ $index }}" tabindex="-1"
                aria-labelledby="editTemplateDokumenModalLabel{{ $jenis->id }}{{ $index }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('template-dokumen.update', $document->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTemplateDokumenModalLabel{{ $jenis->id }}{{ $index }}">
                                    <i class="fas fa-edit" style="color:#F59E0B; margin-right:8px;"></i>
                                    Edit File — {{ $keterangan }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="spi-form-group">
                                    <label class="spi-form-label" for="dokumen">Pilih File</label>
                                    <input type="file" class="form-control-file" id="dokumen" name="dokumen"
                                        accept="{{ $acceptTypes }}" required>
                                    <small style="font-size:0.75rem; color:#94A3B8; margin-top:6px; display:block;">{{ $fileTypeInfo }}</small>
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
        @else
            {{-- Upload Modal --}}
            <div class="modal fade" id="uploadModal{{ $jenis->id }}{{ $index }}" tabindex="-1"
                aria-labelledby="uploadModalLabel{{ $jenis->id }}{{ $index }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('template-dokumen.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $jenis->id }}">
                            <input type="hidden" name="judul" value="{{ $keterangan }}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel{{ $jenis->id }}{{ $index }}">
                                    <i class="fas fa-upload" style="color:#173F9E; margin-right:8px;"></i>
                                    Upload File — {{ $keterangan }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="spi-form-group">
                                    <label class="spi-form-label" for="dokumen">Pilih File</label>
                                    <input type="file" class="form-control-file" id="dokumen" name="dokumen"
                                        accept="{{ $acceptTypes }}" required>
                                    <small style="font-size:0.75rem; color:#94A3B8; margin-top:6px; display:block;">{{ $fileTypeInfo }}</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="spi-btn spi-btn-ghost spi-btn-sm" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="spi-btn spi-btn-primary spi-btn-sm">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endfor
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
                    <span class="spi-page-breadcrumb-current">Template Dokumen</span>
                </div>
                <h1 class="spi-page-title">Template Dokumen</h1>
                <p class="spi-page-subtitle">Kelola template dokumen standar untuk kegiatan audit internal.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ url()->previous() }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">

            {{-- ─── Main Table Card ─── --}}
            <div class="spi-card">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">Daftar Template Dokumen</div>
                        <div class="spi-card-subtitle">Download dan kelola template dokumen standar audit</div>
                    </div>
                    <span class="spi-badge spi-badge-info">
                        <i class="fas fa-file-alt"></i>
                        Template Resmi
                    </span>
                </div>

                <div class="spi-table-wrapper" style="border:none; border-radius:0;">
                    <table class="spi-table">
                        <thead>
                            <tr class="text-center">
                                <th style="width:5%;">No</th>
                                <th class="text-left">Jenis Kegiatan</th>
                                <th class="text-left" colspan="2">Nama Berkas</th>
                                <th class="text-left">Keterangan</th>
                                <th>Waktu Pengumpulan</th>
                                @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                    <th class="text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($jenisDokumen as $jenis)
                                @php
                                    $documents = $jenis->templateDokumen;
                                    $filteredKeterangan = [];
                                    if ($jenis->id == 1) {
                                        $filteredKeterangan = [$defaultKeterangan[4]];
                                    } elseif ($jenis->id == 2) {
                                        $filteredKeterangan = array_slice($defaultKeterangan, 0, 5);
                                    } elseif ($jenis->id == 3) {
                                        $filteredKeterangan = [$defaultKeterangan[5]];
                                    }
                                    $rowCount = count($filteredKeterangan);
                                @endphp
                                @for ($index = 0; $index < $rowCount; $index++)
                                    @php
                                        $keterangan = $filteredKeterangan[$index];
                                        if ($documents == null) {
                                            $document = null;
                                        } else {
                                            $document = $documents->firstWhere('judul', $keterangan);
                                        }
                                    @endphp
                                    <tr>
                                        @if ($index == 0)
                                            <td rowspan="{{ $rowCount }}" class="text-center" style="color:#94A3B8; font-size:0.8rem; font-weight:600;">
                                                {{ $no++ }}
                                            </td>
                                            <td rowspan="{{ $rowCount }}" style="font-weight:600; color:#1E293B; font-size:0.84rem;">
                                                {{ $jenis->jenis }}
                                            </td>
                                        @endif

                                        <td style="font-size:0.82rem; color:#475569;">
                                            @if ($document)
                                                <div style="display:flex; align-items:center; gap:8px;">
                                                    <i class="fas fa-file" style="color:#3B82F6; font-size:0.85rem;"></i>
                                                    {{ $document->dokumen }}
                                                </div>
                                            @else
                                                <span class="spi-badge spi-badge-gray">
                                                    <i class="fas fa-clock"></i>
                                                    Belum diupload
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($document)
                                                <a href="{{ asset('template_dokumen/' . $document->dokumen) }}"
                                                    target="_blank"
                                                    class="spi-btn spi-btn-success spi-btn-icon-sm"
                                                    title="Download Dokumen">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </td>

                                        <td style="font-size:0.82rem; color:#64748B;">
                                            <span class="spi-badge spi-badge-primary" style="font-size:0.72rem;">{{ $keterangan }}</span>
                                        </td>

                                        <td class="text-center" style="font-size:0.78rem; color:#94A3B8; white-space:nowrap;">
                                            {{ $document ? $document->updated_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') : '—' }}
                                        </td>

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <td class="text-center">
                                                @if ($document)
                                                    <button
                                                        data-target="#editTemplateDokumenModal{{ $jenis->id }}{{ $index }}"
                                                        class="spi-btn spi-btn-warning spi-btn-sm"
                                                        data-toggle="modal"
                                                        title="Edit Dokumen">
                                                        <i class="fas fa-edit"></i>
                                                        Ubah
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="spi-btn spi-btn-primary spi-btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#uploadModal{{ $jenis->id }}{{ $index }}">
                                                        <i class="fas fa-upload"></i>
                                                        Upload
                                                    </button>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endfor
                            @endforeach
                        </tbody>
                    </table>
                </div>

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