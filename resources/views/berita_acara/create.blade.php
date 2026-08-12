@extends('layout.app')
@section('title', 'Tambah Berita Acara')

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
                    <a href="{{ route('berita-acara.index') }}">Berita Acara</a>
                    <span class="spi-page-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="spi-page-breadcrumb-current">Tambah</span>
                </div>
                <h1 class="spi-page-title">Tambah Berita Acara</h1>
                <p class="spi-page-subtitle">Lengkapi detail rapat dan unggah dokumen atau foto pendukung.</p>
            </div>
            <div class="spi-page-header-actions">
                <a href="{{ route('berita-acara.index') }}" class="spi-btn spi-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="section-body">
            <div class="spi-card">
                <div class="spi-card-header">
                    <div>
                        <div class="spi-card-title">Form Berita Acara</div>
                        <div class="spi-card-subtitle">Tandai field bertanda <span style="color:#EF4444;">*</span> wajib diisi</div>
                    </div>
                    <span class="spi-badge spi-badge-primary"><i class="fas fa-file-alt"></i> Notulen Rapat</span>
                </div>

                <div class="spi-card-body">
                    <form action="{{ route('berita-acara.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ─── Row 1: Judul / Tanggal / Lokasi ─── --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="spi-form-group">
                                    <label class="spi-form-label" for="title">
                                        Judul <span style="color:#EF4444;">*</span>
                                    </label>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           class="spi-form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}"
                                           placeholder="Masukkan judul berita acara..."
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback d-block" style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="spi-form-group">
                                    <label class="spi-form-label" for="meeting_date">Tanggal Rapat</label>
                                    <input type="date"
                                           id="meeting_date"
                                           name="meeting_date"
                                           class="spi-form-control @error('meeting_date') is-invalid @enderror"
                                           value="{{ old('meeting_date') }}">
                                    @error('meeting_date')
                                        <div class="invalid-feedback d-block" style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="spi-form-group">
                                    <label class="spi-form-label" for="location">Lokasi</label>
                                    <input type="text"
                                           id="location"
                                           name="location"
                                           class="spi-form-control @error('location') is-invalid @enderror"
                                           value="{{ old('location') }}"
                                           placeholder="Misal: Ruang Rapat Utama">
                                    @error('location')
                                        <div class="invalid-feedback d-block" style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ─── Ringkasan ─── --}}
                        <div class="spi-form-group">
                            <label class="spi-form-label" for="summary">Ringkasan</label>
                            <textarea id="summary"
                                      name="summary"
                                      class="spi-form-control @error('summary') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Catat poin-poin penting hasil rapat...">{{ old('summary') }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback d-block" style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ─── Divider ─── --}}
                        <div style="height:1px; background:#F1F5F9; margin:24px 0;"></div>

                        {{-- ─── Dokumen PDF ─── --}}
                        <div class="spi-form-group">
                            <label class="spi-form-label">
                                <i class="fas fa-file-pdf" style="color:#EF4444; margin-right:6px;"></i>
                                Dokumen PDF
                            </label>
                            <div style="border:2px dashed #E2E8F0; border-radius:12px; padding:20px; background:#F8FAFC; transition:border-color 0.15s;"
                                 onmouseover="this.style.borderColor='#173F9E';" onmouseout="this.style.borderColor='#E2E8F0';">
                                <input type="file"
                                       class="@error('documents.*') is-invalid @enderror"
                                       id="documents"
                                       name="documents[]"
                                       accept="application/pdf"
                                       multiple
                                       style="display:block; width:100%; font-size:0.84rem; font-family:inherit; color:#475569;">
                                @error('documents.*')
                                    <div style="font-size:0.78rem; color:#EF4444; margin-top:6px;">{{ $message }}</div>
                                @enderror
                                <div style="font-size:0.75rem; color:#94A3B8; margin-top:8px;">
                                    <i class="fas fa-info-circle"></i>
                                    Format: PDF — Maks. 10 dokumen, masing-masing maks. 10MB
                                </div>
                            </div>
                        </div>

                        {{-- ─── Galeri Foto ─── --}}
                        <div class="spi-form-group">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                                <label class="spi-form-label mb-0">
                                    <i class="fas fa-images" style="color:#3B82F6; margin-right:6px;"></i>
                                    Galeri Foto
                                </label>
                                <button class="spi-btn spi-btn-outline spi-btn-sm" type="button" id="addImageField">
                                    <i class="fas fa-plus"></i>
                                    Tambah Gambar
                                </button>
                            </div>
                            <div style="font-size:0.75rem; color:#94A3B8; margin-bottom:12px;">
                                <i class="fas fa-info-circle"></i>
                                Format: JPG, PNG — Maks. 10 gambar, masing-masing maks. 5MB. Caption bersifat opsional.
                            </div>

                            <div id="imageCollection" style="display:flex; flex-direction:column; gap:12px;">
                                <div class="image-item" style="border:1px solid #E2E8F0; border-radius:12px; padding:18px; background:#FAFBFC;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="spi-form-group" style="margin-bottom:12px;">
                                                <label class="spi-form-label" style="font-size:0.78rem;">File Gambar</label>
                                                <input type="file"
                                                       name="images[]"
                                                       class="@error('images.0') is-invalid @enderror"
                                                       accept="image/*"
                                                       style="display:block; width:100%; font-size:0.84rem; color:#475569;">
                                                @error('images.0')
                                                    <div style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="spi-form-group" style="margin-bottom:12px;">
                                                <label class="spi-form-label" style="font-size:0.78rem;">Caption (Opsional)</label>
                                                <input type="text"
                                                       name="image_captions[]"
                                                       class="spi-form-control @error('image_captions.0') is-invalid @enderror"
                                                       maxlength="255"
                                                       placeholder="Deskripsi singkat foto">
                                                @error('image_captions.0')
                                                    <div style="font-size:0.78rem; color:#EF4444; margin-top:4px;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center justify-content-end pt-1">
                                            <button type="button" class="spi-btn spi-btn-danger spi-btn-icon remove-image" style="display:none;" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ─── Submit ─── --}}
                        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                            <a href="{{ route('berita-acara.index') }}" class="spi-btn spi-btn-ghost">Batal</a>
                            <button type="submit" class="spi-btn spi-btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan Berita Acara
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const MAX_DOCUMENT_UPLOADS = 10;
        const MAX_IMAGE_UPLOADS = 10;
        const imageCollection = document.getElementById('imageCollection');
        const addImageFieldButton = document.getElementById('addImageField');
        const documentInput = document.getElementById('documents');

        if (!imageCollection || !addImageFieldButton) return;

        const getImageItems = () => Array.from(imageCollection.querySelectorAll('.image-item'));

        const updateRemoveButtons = () => {
            const items = getImageItems();
            items.forEach((item) => {
                const removeButton = item.querySelector('.remove-image');
                if (removeButton) {
                    removeButton.style.display = items.length > 1 ? 'inline-flex' : 'none';
                }
            });
        };

        const buildImageField = () => {
            const wrapper = document.createElement('div');
            wrapper.className = 'image-item';
            wrapper.style.cssText = 'border:1px solid #E2E8F0; border-radius:12px; padding:18px; background:#FAFBFC;';
            wrapper.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="spi-form-group" style="margin-bottom:12px;">
                            <label class="spi-form-label" style="font-size:0.78rem;">File Gambar</label>
                            <input type="file" name="images[]" class="" accept="image/*"
                                   style="display:block; width:100%; font-size:0.84rem; color:#475569;">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="spi-form-group" style="margin-bottom:12px;">
                            <label class="spi-form-label" style="font-size:0.78rem;">Caption (Opsional)</label>
                            <input type="text" name="image_captions[]" class="spi-form-control"
                                   maxlength="255" placeholder="Deskripsi singkat foto">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-end pt-1">
                        <button type="button" class="spi-btn spi-btn-danger spi-btn-icon remove-image" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            return wrapper;
        };

        addImageFieldButton.addEventListener('click', function () {
            if (getImageItems().length >= MAX_IMAGE_UPLOADS) {
                alert('Maksimal 10 gambar per unggahan.');
                return;
            }
            const field = buildImageField();
            imageCollection.appendChild(field);
            updateRemoveButtons();
        });

        imageCollection.addEventListener('click', function (event) {
            const button = event.target.closest('.remove-image');
            if (!button) return;

            const items = getImageItems();
            if (items.length <= 1) return;

            const item = button.closest('.image-item');
            if (item) {
                item.remove();
                updateRemoveButtons();
            }
        });

        if (documentInput) {
            documentInput.addEventListener('change', function () {
                if (this.files.length > MAX_DOCUMENT_UPLOADS) {
                    alert('Maksimal 10 dokumen per unggahan.');
                    this.value = '';
                }
            });
        }

        updateRemoveButtons();
    })();
</script>
@endpush
