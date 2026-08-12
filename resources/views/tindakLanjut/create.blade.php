{{-- ════════════════════════════════════════════════════════════════
     Versi lama (dikomentari developer sebelumnya) — DIBIARKAN APA ADANYA
     Versi aktif mulai @extends di bawah ini
════════════════════════════════════════════════════════════════ --}}
{{-- @extends('layout.app')
@section('title', 'Tambah Rekomendasi')
@section('main')
    ... (old version 1 - commented)
@endsection --}}

{{-- @extends('layout.app')
@section('title', 'Tambah Rekomendasi')
@section('main')
    ... (old version 2 - commented)
@endsection --}}


@extends('layout.app')
@section('title', isset($post) ? 'Edit Rekomendasi' : 'Tambah Rekomendasi')

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
                    <a href="{{ route('tindak-lanjut.index') }}">Tindak Lanjut</a>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="spi-page-breadcrumb-current">{{ isset($post) ? 'Edit Rekomendasi' : 'Tambah Rekomendasi' }}</span>
                </div>
                <h1 class="spi-page-title">{{ isset($post) ? 'Edit Rekomendasi' : 'Tambah Rekomendasi' }}</h1>
                <p class="spi-page-subtitle">Kelola rekomendasi tindak lanjut berdasarkan temuan audit.</p>
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
                        <div class="spi-card-title">Form Rekomendasi</div>
                        <div class="spi-card-subtitle">Pilih judul penugasan, kemudian isi data RTM (Risiko, Temuan, dan Rekomendasi).</div>
                    </div>
                    <span class="spi-badge spi-badge-primary">
                        <i class="fas fa-list-check"></i>
                        RTM
                    </span>
                </div>

                <div class="spi-card-body">
                    <form
                        action="{{ isset($post) ? route('tindak-lanjut.updateRekomendasi', $post->id) : route('tindak-lanjut.storeRekomendasi') }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ─── Judul ─── --}}
                        <div class="spi-form-group">
                            <label class="spi-form-label" for="judul">Judul Penugasan</label>
                            <select name="judul" id="judul" class="spi-form-control spi-form-select">
                                <option value="">Pilih Judul</option>
                                @foreach ($posts as $p)
                                    <option value="{{ $p->id }}"
                                        {{ isset($post) && $post->id == $p->id ? 'selected' : '' }}>
                                        {{ $p->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('judul')
                                <div style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="height:1px; background:#F1F5F9; margin:20px 0;"></div>

                        {{-- ─── RTM Container ─── --}}
                        <div style="margin-bottom:12px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                <label class="spi-form-label mb-0" style="font-size:0.88rem;">
                                    <i class="fas fa-clipboard-list" style="color:#173F9E; margin-right:6px;"></i>
                                    Daftar RTM
                                </label>
                                <button type="button" id="add-rtm" class="spi-btn spi-btn-success spi-btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Tambah RTM
                                </button>
                            </div>

                            <div id="rtm-container" style="display:flex; flex-direction:column; gap:12px;">
                                @if (isset($post) && $post->rtms->isNotEmpty())
                                    @foreach ($post->rtms as $index => $rtm)
                                        @include('partials.rekomendasi-form', [
                                            'index' => $index,
                                            'rtm' => $rtm,
                                        ])
                                    @endforeach
                                @else
                                    @include('partials.rekomendasi-form', ['index' => 0])
                                @endif
                            </div>
                        </div>

                        {{-- ─── Actions ─── --}}
                        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; padding-top:16px; border-top:1px solid #F1F5F9;">
                            <button type="reset" class="spi-btn spi-btn-ghost">
                                <i class="fas fa-rotate-left"></i>
                                Reset
                            </button>
                            <button type="submit" class="spi-btn spi-btn-primary">
                                <i class="fas fa-save"></i>
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let rtmIndex = {{ isset($post) ? $post->rtms->count() : 1 }};

        // Handle judul selection change
        $('#judul').on('change', function() {
            const selectedId = $(this).val();
            if (selectedId) {
                $.ajax({
                    url: `/get-rtm/${selectedId}`,
                    method: 'GET',
                    success: function(response) {
                        $('#rtm-container').empty();
                        rtmIndex = 0;

                        response.rtms.forEach(rtm => {
                            const newRtmForm = `
                                <div class="rtm-form" style="border:1px solid #E2E8F0; border-radius:12px; padding:18px; background:#FAFBFC; margin-bottom:12px;">
                                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <div style="width:28px; height:28px; border-radius:8px; background:#EAF0FF; display:flex; align-items:center; justify-content:center;">
                                                <i class="fas fa-clipboard-list" style="font-size:0.75rem; color:#173F9E;"></i>
                                            </div>
                                            <span style="font-weight:600; font-size:0.84rem; color:#1E293B;">Item RTM</span>
                                        </div>
                                        <button type="button" class="spi-btn spi-btn-danger spi-btn-icon-sm remove-rtm" title="Hapus RTM">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="spi-form-group">
                                                <label class="spi-form-label" style="font-size:0.8rem;">Temuan</label>
                                                <textarea name="rtm[${rtmIndex}][temuan]" class="spi-form-control" rows="3" placeholder="Masukkan temuan audit...">${rtm.temuan || ''}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="spi-form-group">
                                                <label class="spi-form-label" style="font-size:0.8rem;">Rekomendasi</label>
                                                <textarea name="rtm[${rtmIndex}][rekomendasi]" class="spi-form-control" rows="3" placeholder="Masukkan rekomendasi tindak lanjut...">${rtm.rekomendasi || ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#rtm-container').append(newRtmForm);
                            rtmIndex++;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching RTMs:', error);
                    }
                });
            } else {
                $('#rtm-container').empty();
                rtmIndex = 0;
                $('#rtm-container').append(`@include('partials.rekomendasi-form', ['index' => 0])`);
                rtmIndex = 1;
            }
        });

        // Tambah RTM
        $('#add-rtm').on('click', function() {
            const newRtmForm = `
                <div class="rtm-form" style="border:1px solid #E2E8F0; border-radius:12px; padding:18px; background:#FAFBFC; margin-bottom:12px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; background:#EAF0FF; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-clipboard-list" style="font-size:0.75rem; color:#173F9E;"></i>
                            </div>
                            <span style="font-weight:600; font-size:0.84rem; color:#1E293B;">Item RTM</span>
                        </div>
                        <button type="button" class="spi-btn spi-btn-danger spi-btn-icon-sm remove-rtm" title="Hapus RTM">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="spi-form-group">
                                <label class="spi-form-label" style="font-size:0.8rem;">Temuan</label>
                                <textarea name="rtm[${rtmIndex}][temuan]" class="spi-form-control" rows="3" placeholder="Masukkan temuan audit..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="spi-form-group">
                                <label class="spi-form-label" style="font-size:0.8rem;">Rekomendasi</label>
                                <textarea name="rtm[${rtmIndex}][rekomendasi]" class="spi-form-control" rows="3" placeholder="Masukkan rekomendasi tindak lanjut..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#rtm-container').append(newRtmForm);
            rtmIndex++;
        });

        // Hapus RTM
        $(document).on('click', '.remove-rtm', function() {
            $(this).closest('.rtm-form').remove();
        });
    });
</script>
@endpush

@endsection
