@extends('layout.app')

@section('title', 'Pengaturan Web Profil')

@push('style')
<style>
    /* ── Section Card ── */
    .lps-section-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .lps-section-header {
        background: linear-gradient(135deg, #173F9E, #2557D6);
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }
    .lps-section-body { padding: 22px; }
    .lps-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 5px;
        display: block;
    }
    .lps-hint {
        font-size: 0.73rem;
        color: #94A3B8;
        margin-top: 3px;
        display: block;
    }
    .lps-input {
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.85rem;
        width: 100%;
        color: #1E293B;
        transition: border 0.15s;
        background: #fff;
    }
    .lps-input:focus {
        outline: none;
        border-color: #173F9E;
        box-shadow: 0 0 0 3px rgba(23,63,158,0.08);
    }
    .color-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .color-picker-btn {
        width: 40px;
        height: 38px;
        border-radius: 8px;
        border: 1.5px solid #E2E8F0;
        cursor: pointer;
        padding: 2px;
        flex-shrink: 0;
    }

    /* ── Hero Display Mode Radio Pill ── */
    .mode-radio-group {
        display: flex;
        gap: 10px;
    }
    .mode-radio-group input[type="radio"] { display: none; }
    .mode-radio-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 10px;
        border: 2px solid #E2E8F0;
        font-size: 0.83rem;
        font-weight: 700;
        color: #64748B;
        cursor: pointer;
        background: #F8FAFC;
        transition: all 0.15s ease;
        user-select: none;
    }
    .mode-radio-group input[type="radio"]:checked + label {
        border-color: #173F9E;
        background: #EAF0FF;
        color: #173F9E;
    }
    .mode-radio-group label:hover { background: #EAF0FF; border-color: #93B4F9; }

    /* ── Upload Drop Zone ── */
    .upload-zone {
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        background: #F8FAFC;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: #173F9E;
        background: #EAF0FF;
    }
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-zone-icon {
        font-size: 1.8rem;
        color: #94A3B8;
        margin-bottom: 8px;
    }
    .upload-zone-text { font-size: 0.82rem; color: #64748B; font-weight: 600; }
    .upload-zone-hint { font-size: 0.72rem; color: #94A3B8; margin-top: 3px; }

    /* ── Preview card (in sidebar) ── */
    #prev-card {
        border-radius: 20px;
        padding: 28px 26px;
        color: #fff;
        box-shadow: 0 14px 35px rgba(23,63,158,0.25);
        transition: background 0.4s ease;
    }
    #prev-card.anim-on { animation: floatPrev 4s ease-in-out infinite; }
    .prev_feat_card.anim-on { animation: floatPrev 4s ease-in-out infinite; }
    .prev_feat_card:nth-child(2).anim-on { animation-delay: 1.2s; }
    .prev_feat_card:nth-child(3).anim-on { animation-delay: 2.4s; }
    .prev_feat_card:nth-child(4).anim-on { animation-delay: 0.6s; }
    .prev_feat_card:nth-child(5).anim-on { animation-delay: 1.8s; }
    .prev_feat_card:nth-child(6).anim-on { animation-delay: 3.0s; }
    @keyframes floatPrev {
        0%,100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }
    .prev-icon-box {
        width: 50px; height: 50px;
        background: #fff;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transition: color 0.3s;
    }
    #prev-image-wrap img {
        width: 100%;
        border-radius: 14px;
        object-fit: cover;
        max-height: 200px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.14);
    }

    /* ── Real toggle switch ── */
    .lps-toggle-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 6px;
    }
    .lps-toggle {
        -webkit-appearance: none;
        appearance: none;
        width: 44px;
        height: 24px;
        background: #CBD5E1;
        border-radius: 999px;
        cursor: pointer;
        position: relative;
        transition: background 0.2s ease;
        flex-shrink: 0;
        border: none;
        outline: none;
    }
    .lps-toggle::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        width: 16px;
        height: 16px;
        background: #fff;
        border-radius: 50%;
        transition: transform 0.2s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.25);
    }
    .lps-toggle:checked { background: #173F9E; }
    .lps-toggle:checked::before { transform: translateX(20px); }

    /* ── Save bar ── */
    .save-bar {
        position: sticky;
        bottom: 0;
        background: rgba(255,255,255,0.96);
        backdrop-filter: blur(8px);
        border-top: 1px solid #E2E8F0;
        padding: 14px 0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
        z-index: 50;
    }

    /* Conditional section visibility */
    .card-fields, .image-fields { transition: opacity 0.2s; }
    .card-fields.hidden, .image-fields.hidden {
        opacity: 0.35;
        pointer-events: none;
    }
</style>
@endpush

@section('main')
<div class="main-content">
<section class="section">

    {{-- PAGE HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;background:#fff;border-radius:16px;padding:18px 24px;border:1px solid #E2E8F0;margin-bottom:24px;box-shadow:0 2px 10px rgba(11,23,54,0.04);">
        <div>
            <h1 style="font-size:1.35rem;font-weight:800;color:#111827;margin:0;display:flex;align-items:center;gap:10px;">
                <span style="width:36px;height:36px;background:linear-gradient(135deg,#173F9E,#2557D6);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-sliders" style="color:#fff;font-size:0.9rem;"></i>
                </span>
                Pengaturan Web Profil
            </h1>
            <p style="color:#64748B;font-size:0.82rem;margin:4px 0 0 46px;">
                Ubah teks, warna/tema, kartu, banner, dan footer pada halaman landing publik secara dinamis.
            </p>
        </div>
        <div style="display:flex;gap:8px;align-items:center;">
            <a href="{{ url('/welcome') }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:1.5px solid #173F9E;color:#173F9E;border-radius:10px;font-weight:700;font-size:0.82rem;text-decoration:none;background:#fff;">
                <i class="fas fa-arrow-up-right-from-square"></i> Lihat Halaman
            </a>
            <form action="{{ route('admin.landing-settings.reset') }}" method="POST"
                  onsubmit="return confirm('Reset semua pengaturan ke default? Perubahan yang belum disimpan akan hilang.');">
                @csrf
                <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:1.5px solid #EF4444;color:#EF4444;border-radius:10px;font-weight:700;font-size:0.82rem;background:#fff;cursor:pointer;">
                    <i class="fas fa-rotate-left"></i> Reset Default
                </button>
            </form>
        </div>
    </div>

    {{-- FLASH --}}
    @if (session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;border-radius:12px;padding:13px 18px;margin-bottom:20px;color:#166534;font-weight:600;font-size:0.875rem;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div style="background:#FEE2E2;border:1px solid #FCA5A5;border-radius:12px;padding:13px 18px;margin-bottom:20px;color:#991B1B;font-weight:600;font-size:0.875rem;">
        <i class="fas fa-triangle-exclamation mr-2"></i> Ada kesalahan validasi. Periksa kembali isian Anda.
    </div>
    @endif

    {{-- Main form — multipart for file upload --}}
    <form action="{{ route('admin.landing-settings.update') }}" method="POST" id="lpsForm"
          enctype="multipart/form-data">
    @csrf

    <div class="row">

        {{-- ══════════════════════ LEFT FORM ══════════════════════ --}}
        <div class="col-lg-7">

            {{-- 1. TEMA WARNA --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-palette"></i> 1 — Skema Warna &amp; Tema</div>
                <div class="lps-section-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Warna Utama (Primary)</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_primary"
                                       value="{{ old('theme_primary_color', $settings['theme_primary_color'] ?? '#173F9E') }}"
                                       oninput="syncColor('cp_primary','txt_primary')">
                                <input type="text" class="lps-input" id="txt_primary" name="theme_primary_color"
                                       value="{{ old('theme_primary_color', $settings['theme_primary_color'] ?? '#173F9E') }}"
                                       oninput="syncColor('txt_primary','cp_primary')">
                            </div>
                            <span class="lps-hint">Tombol utama, tombol login, link navbar, ikon statistik &amp; prinsip pengawasan.</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Warna Aksen / Highlight</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_secondary"
                                       value="{{ old('theme_secondary_color', $settings['theme_secondary_color'] ?? '#F4A623') }}"
                                       oninput="syncColor('cp_secondary','txt_secondary')">
                                <input type="text" class="lps-input" id="txt_secondary" name="theme_secondary_color"
                                       value="{{ old('theme_secondary_color', $settings['theme_secondary_color'] ?? '#F4A623') }}"
                                       oninput="syncColor('txt_secondary','cp_secondary')">
                            </div>
                            <span class="lps-hint">Garis bawah highlight teks hero &amp; tag statistik.</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Latar Belakang Hero</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_bg"
                                       value="{{ old('theme_bg_color', $settings['theme_bg_color'] ?? '#F7F9FC') }}"
                                       oninput="syncColor('cp_bg','txt_bg')">
                                <input type="text" class="lps-input" id="txt_bg" name="theme_bg_color"
                                       value="{{ old('theme_bg_color', $settings['theme_bg_color'] ?? '#F7F9FC') }}"
                                       oninput="syncColor('txt_bg','cp_bg')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Warna Gelap / Default Navy</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_dark"
                                       value="{{ old('theme_dark_bg', $settings['theme_dark_bg'] ?? '#0B1736') }}"
                                       oninput="syncColor('cp_dark','txt_dark')">
                                <input type="text" class="lps-input" id="txt_dark" name="theme_dark_bg"
                                       value="{{ old('theme_dark_bg', $settings['theme_dark_bg'] ?? '#0B1736') }}"
                                       oninput="syncColor('txt_dark','cp_dark')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. TEKS HERO --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-heading"></i> 2 — Teks Hero (Halaman Utama)</div>
                <div class="lps-section-body">
                    <div class="mb-3">
                        <label class="lps-label">Badge Tag Hero</label>
                        <input type="text" class="lps-input" id="inp_badge" name="hero_badge_text"
                               value="{{ old('hero_badge_text', $settings['hero_badge_text'] ?? '') }}"
                               placeholder="SISTEM INFORMASI SPI">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Utama (H1)</label>
                        <textarea class="lps-input" id="inp_title" name="hero_title" rows="2"
                                  placeholder="Sistem Informasi Supervisi dan Pengawasan Internal">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                        <span class="lps-hint">Teks lengkap judul utama, termasuk bagian highlight.</span>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Teks Highlight (Diberi Garis Bawah Aksen)</label>
                        <input type="text" class="lps-input" name="hero_highlight_text"
                               value="{{ old('hero_highlight_text', $settings['hero_highlight_text'] ?? '') }}"
                               placeholder="Pengawasan Internal">
                        <span class="lps-hint">Harus merupakan bagian dari Judul Utama di atas.</span>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Hero</label>
                        <textarea class="lps-input" id="inp_desc" name="hero_description" rows="3"
                                  placeholder="Solusi digital terpadu untuk manajemen audit internal...">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Teks Tombol Utama</label>
                            <input type="text" class="lps-input" id="inp_btn1" name="hero_btn_primary_text"
                                   value="{{ old('hero_btn_primary_text', $settings['hero_btn_primary_text'] ?? '') }}"
                                   placeholder="Mulai Sekarang →">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">URL Tombol Utama</label>
                            <input type="text" class="lps-input" name="hero_btn_primary_url"
                                   value="{{ old('hero_btn_primary_url', $settings['hero_btn_primary_url'] ?? '') }}"
                                   placeholder="/login">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Teks Tombol Sekunder</label>
                            <input type="text" class="lps-input" id="inp_btn2" name="hero_btn_secondary_text"
                                   value="{{ old('hero_btn_secondary_text', $settings['hero_btn_secondary_text'] ?? '') }}"
                                   placeholder="Pelajari Lebih Lanjut">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">URL Tombol Sekunder</label>
                            <input type="text" class="lps-input" name="hero_btn_secondary_url"
                                   value="{{ old('hero_btn_secondary_url', $settings['hero_btn_secondary_url'] ?? '') }}"
                                   placeholder="#tentang">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. TAMPILAN KANAN HERO --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-layer-group"></i> 3 — Tampilan Kanan Hero</div>
                <div class="lps-section-body">

                    {{-- Mode selector --}}
                    <div class="mb-4">
                        <label class="lps-label" style="margin-bottom:10px;">Pilih Tampilan Sisi Kanan</label>
                        @php $dispMode = old('hero_display_mode', $settings['hero_display_mode'] ?? 'card'); @endphp
                        <div class="mode-radio-group">
                            <input type="radio" name="hero_display_mode" id="mode_card" value="card"
                                   {{ $dispMode === 'card' ? 'checked' : '' }}>
                            <label for="mode_card">
                                <i class="fas fa-credit-card"></i> Kartu Mengambang
                            </label>

                            <input type="radio" name="hero_display_mode" id="mode_image" value="image"
                                   {{ $dispMode === 'image' ? 'checked' : '' }}>
                            <label for="mode_image">
                                <i class="fas fa-image"></i> Gambar / Foto
                            </label>
                        </div>
                    </div>

                    {{-- ── Card fields ── --}}
                    <div id="card-fields" class="card-fields {{ $dispMode === 'image' ? 'hidden' : '' }}">
                        <div style="background:#F0F4FF;border-radius:10px;padding:14px 16px;margin-bottom:16px;">
                            <p style="font-size:0.79rem;color:#3B5ED6;font-weight:600;margin:0;">
                                <i class="fas fa-info-circle mr-1"></i>
                                Kartu mengambang bergradien akan tampil di sisi kanan hero.
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="lps-label">Judul Kartu</label>
                            <input type="text" class="lps-input" id="inp_card_title" name="floating_card_title"
                                   value="{{ old('floating_card_title', $settings['floating_card_title'] ?? '') }}"
                                   placeholder="Audit Management">
                        </div>
                        <div class="mb-3">
                            <label class="lps-label">Deskripsi Kartu</label>
                            <textarea class="lps-input" id="inp_card_desc" name="floating_card_desc" rows="2"
                                      placeholder="Kelola seluruh proses audit internal...">{{ old('floating_card_desc', $settings['floating_card_desc'] ?? '') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="lps-label">Ikon (FontAwesome Class)</label>
                                <div style="display:flex;gap:8px;align-items:center;">
                                    <span id="icon_preview" style="width:38px;height:38px;background:#EAF0FF;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#173F9E;font-size:1.1rem;flex-shrink:0;">
                                        <i class="{{ $settings['floating_card_icon'] ?? 'fas fa-clipboard-check' }}"></i>
                                    </span>
                                    <input type="text" class="lps-input" id="inp_icon" name="floating_card_icon"
                                           value="{{ old('floating_card_icon', $settings['floating_card_icon'] ?? '') }}"
                                           placeholder="fas fa-clipboard-check">
                                </div>
                                <span class="lps-hint">Contoh: fas fa-shield-halved, fas fa-chart-line</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="lps-label">Warna Ikon</label>
                                <div class="color-row">
                                    <input type="color" class="color-picker-btn" id="cp_icon_color"
                                           value="{{ old('floating_card_icon_color', $settings['floating_card_icon_color'] ?? '#173F9E') }}"
                                           oninput="syncColor('cp_icon_color','txt_icon_color')">
                                    <input type="text" class="lps-input" id="txt_icon_color" name="floating_card_icon_color"
                                           value="{{ old('floating_card_icon_color', $settings['floating_card_icon_color'] ?? '#173F9E') }}"
                                           oninput="syncColor('txt_icon_color','cp_icon_color')">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="lps-label">Gradien Kartu — Warna Awal</label>
                                <div class="color-row">
                                    <input type="color" class="color-picker-btn" id="cp_grad_start"
                                           value="{{ old('floating_card_gradient_start', $settings['floating_card_gradient_start'] ?? '#2557D6') }}"
                                           oninput="syncColor('cp_grad_start','txt_grad_start')">
                                    <input type="text" class="lps-input" id="txt_grad_start" name="floating_card_gradient_start"
                                           value="{{ old('floating_card_gradient_start', $settings['floating_card_gradient_start'] ?? '#2557D6') }}"
                                           oninput="syncColor('txt_grad_start','cp_grad_start')">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="lps-label">Gradien Kartu — Warna Akhir</label>
                                <div class="color-row">
                                    <input type="color" class="color-picker-btn" id="cp_grad_end"
                                           value="{{ old('floating_card_gradient_end', $settings['floating_card_gradient_end'] ?? '#173F9E') }}"
                                           oninput="syncColor('cp_grad_end','txt_grad_end')">
                                    <input type="text" class="lps-input" id="txt_grad_end" name="floating_card_gradient_end"
                                           value="{{ old('floating_card_gradient_end', $settings['floating_card_gradient_end'] ?? '#173F9E') }}"
                                           oninput="syncColor('txt_grad_end','cp_grad_end')">
                                </div>
                            </div>
                        </div>

                        {{-- ── TOGGLE ── --}}
                        <div class="lps-toggle-wrap">
                            <input type="checkbox"
                                   class="lps-toggle"
                                   name="floating_card_animation"
                                   id="toggle_anim"
                                   value="1"
                                   {{ ($settings['floating_card_animation'] ?? '1') == '1' ? 'checked' : '' }}>
                            <label for="toggle_anim" style="font-size:0.84rem;font-weight:600;color:#334155;cursor:pointer;margin:0;user-select:none;">
                                Animasi naik-turun kartu (floating animation)
                            </label>
                        </div>
                    </div>{{-- /card-fields --}}

                    {{-- ── Image fields ── --}}
                    <div id="image-fields" class="image-fields {{ $dispMode === 'card' ? 'hidden' : '' }}">
                        <div style="background:#F0FDF4;border-radius:10px;padding:14px 16px;margin-bottom:16px;">
                            <p style="font-size:0.79rem;color:#166534;font-weight:600;margin:0;">
                                <i class="fas fa-info-circle mr-1"></i>
                                Gambar yang Anda upload akan tampil di sisi kanan hero sebagai ilustrasi.
                            </p>
                        </div>

                        @php $curImg = $settings['hero_image'] ?? ''; @endphp
                        @if($curImg)
                        <div style="margin-bottom:14px;">
                            <label class="lps-label">Gambar Saat Ini</label>
                            <div style="position:relative;display:inline-block;">
                                <img src="{{ asset('landing_images/' . $curImg) }}"
                                     style="max-height:160px;border-radius:12px;border:2px solid #E2E8F0;object-fit:cover;">
                                <span style="position:absolute;top:6px;right:6px;background:rgba(0,0,0,0.55);color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:6px;font-weight:700;">
                                    Aktif
                                </span>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="lps-label">Upload Gambar Baru</label>
                            <div class="upload-zone" id="uploadZone"
                                 ondragover="this.classList.add('drag-over');event.preventDefault();"
                                 ondragleave="this.classList.remove('drag-over');"
                                 ondrop="handleDrop(event);">
                                <input type="file" id="hero_image_input" name="hero_image"
                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                       onchange="previewUpload(this)">
                                <div class="upload-zone-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                                <div class="upload-zone-text" id="upload-text">Klik atau seret gambar ke sini</div>
                                <div class="upload-zone-hint">JPG, PNG, WEBP — maks. 2 MB</div>
                            </div>
                            <div id="upload-preview-wrap" style="margin-top:10px;display:none;">
                                <img id="upload-preview-img" style="max-height:150px;border-radius:10px;border:2px solid #BBF7D0;object-fit:cover;">
                                <button type="button" onclick="clearUpload()"
                                        style="display:block;margin-top:6px;font-size:0.75rem;color:#EF4444;background:none;border:none;cursor:pointer;font-weight:700;">
                                    <i class="fas fa-xmark mr-1"></i> Hapus pilihan
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="lps-label">Alt Text Gambar (opsional)</label>
                            <input type="text" class="lps-input" name="hero_image_alt"
                                   value="{{ old('hero_image_alt', $settings['hero_image_alt'] ?? '') }}"
                                   placeholder="Ilustrasi sistem audit SISPI">
                            <span class="lps-hint">Teks alternatif untuk aksesibilitas dan SEO.</span>
                        </div>
                    </div>{{-- /image-fields --}}

                </div>
            </div>

            {{-- 4. SECTION TENTANG KAMI --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-circle-info"></i> 4 — Section "Tentang Kami"</div>
                <div class="lps-section-body">
                    <div class="mb-3">
                        <label class="lps-label">Badge Text</label>
                        <input type="text" class="lps-input" id="inp_about_badge" name="about_badge"
                               value="{{ old('about_badge', $settings['about_badge'] ?? '') }}"
                               placeholder="TENTANG KAMI">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Section</label>
                        <input type="text" class="lps-input" id="inp_about_title" name="about_title"
                               value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                               placeholder="Transformasi Digital untuk Audit Internal">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Singkat</label>
                        <textarea class="lps-input" id="inp_about_desc" name="about_description" rows="2"
                                  placeholder="SISPI hadir sebagai solusi komprehensif...">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Sub-Section</label>
                        <input type="text" class="lps-input" id="inp_about_why_title" name="about_why_title"
                               value="{{ old('about_why_title', $settings['about_why_title'] ?? '') }}"
                               placeholder="Mengapa Memilih SISPI?">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Paragraf 1</label>
                        <textarea class="lps-input" id="inp_about_why_p1" name="about_why_p1" rows="2">{{ old('about_why_p1', $settings['about_why_p1'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Paragraf 2</label>
                        <textarea class="lps-input" id="inp_about_why_p2" name="about_why_p2" rows="2">{{ old('about_why_p2', $settings['about_why_p2'] ?? '') }}</textarea>
                    </div>

                    @php
                        $savedChecklists = [];
                        if (!empty($settings['about_checklists'])) {
                            $savedChecklists = json_decode($settings['about_checklists'], true);
                        }
                        if (!is_array($savedChecklists) || empty($savedChecklists)) {
                            $savedChecklists = array_filter([
                                $settings['about_checklist_1'] ?? 'Manajemen audit terintegrasi dan terstruktur',
                                $settings['about_checklist_2'] ?? 'Peta risiko yang komprehensif dan real-time',
                                $settings['about_checklist_3'] ?? 'Sistem kolaborasi tim yang efektif',
                                $settings['about_checklist_4'] ?? 'Keamanan data tingkat enterprise',
                            ]);
                        }
                    @endphp

                    <hr style="border-top:1px dashed #CBD5E1; margin:20px 0;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div style="font-weight:700; color:#111827; font-size:0.875rem;"><i class="fas fa-check-double text-primary mr-1"></i> Poin Checklist Fitur Unggulan</div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold" onclick="addChecklistItem('')" style="font-size:0.75rem; padding:4px 14px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Checklist
                        </button>
                    </div>

                    <div id="checklist-container">
                        @foreach($savedChecklists as $index => $chkVal)
                        <div class="d-flex align-items-center gap-2 mb-2 checklist-item-row">
                            <input type="text" class="lps-input flex-fill chk-input-field" name="about_checklists[]"
                                   value="{{ $chkVal }}" placeholder="Tulis poin checklist..." oninput="refreshPreview()">
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-lg" onclick="removeChecklistItem(this)" style="padding:7px 12px; border-radius:10px; flex-shrink:0;">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <hr style="border-top:1px dashed #CBD5E1; margin:20px 0;">
                    <div style="font-weight:700; color:#111827; font-size:0.875rem; margin-bottom:12px;"><i class="fas fa-shield-halved text-primary mr-1"></i> Prinsip Pengawasan Internal</div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Prinsip Pengawasan</label>
                        <input type="text" class="lps-input" id="inp_about_principles_title" name="about_principles_title"
                               value="{{ old('about_principles_title', $settings['about_principles_title'] ?? '') }}"
                               placeholder="Prinsip Pengawasan Internal">
                    </div>
                    @for($p = 1; $p <= 5; $p++)
                    <div class="mb-2">
                        <label class="lps-label">Nama Prinsip {{ $p }}</label>
                        <input type="text" class="lps-input" id="inp_about_principle_{{ $p }}" name="about_principle_{{ $p }}"
                               value="{{ old('about_principle_'.$p, $settings['about_principle_'.$p] ?? '') }}"
                               placeholder="Nama prinsip {{ $p }}">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 5. SECTION FITUR UNGGULAN --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-grid-2"></i> 5 — Section "Fitur Unggulan"</div>
                <div class="lps-section-body">
                    <div class="mb-3">
                        <label class="lps-label">Badge Text</label>
                        <input type="text" class="lps-input" id="inp_features_badge" name="features_badge"
                               value="{{ old('features_badge', $settings['features_badge'] ?? '') }}"
                               placeholder="FITUR UNGGULAN">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Section</label>
                        <input type="text" class="lps-input" id="inp_features_title" name="features_title"
                               value="{{ old('features_title', $settings['features_title'] ?? '') }}"
                               placeholder="Fitur Lengkap untuk Audit yang Efektif">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Section</label>
                        <textarea class="lps-input" id="inp_features_desc" name="features_description" rows="2"
                                  placeholder="Berbagai fitur canggih yang dirancang...">{{ old('features_description', $settings['features_description'] ?? '') }}</textarea>
                    </div>

                    {{-- Color & Animation controls for Fitur Unggulan Cards --}}
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label class="lps-label">Gradien Kartu — Warna Awal</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_feat_grad_start"
                                       value="{{ old('feature_card_gradient_start', $settings['feature_card_gradient_start'] ?? '#2557D6') }}"
                                       oninput="syncColor('cp_feat_grad_start','txt_feat_grad_start')">
                                <input type="text" class="lps-input" id="txt_feat_grad_start" name="feature_card_gradient_start"
                                       value="{{ old('feature_card_gradient_start', $settings['feature_card_gradient_start'] ?? '#2557D6') }}"
                                       oninput="syncColor('txt_feat_grad_start','cp_feat_grad_start')">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="lps-label">Gradien Kartu — Warna Akhir</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_feat_grad_end"
                                       value="{{ old('feature_card_gradient_end', $settings['feature_card_gradient_end'] ?? '#173F9E') }}"
                                       oninput="syncColor('cp_feat_grad_end','txt_feat_grad_end')">
                                <input type="text" class="lps-input" id="txt_feat_grad_end" name="feature_card_gradient_end"
                                       value="{{ old('feature_card_gradient_end', $settings['feature_card_gradient_end'] ?? '#173F9E') }}"
                                       oninput="syncColor('txt_feat_grad_end','cp_feat_grad_end')">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="lps-label">Warna Ikon Kartu Fitur</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_feat_icon_color"
                                       value="{{ old('feature_card_icon_color', $settings['feature_card_icon_color'] ?? '#173F9E') }}"
                                       oninput="syncColor('cp_feat_icon_color','txt_feat_icon_color')">
                                <input type="text" class="lps-input" id="txt_feat_icon_color" name="feature_card_icon_color"
                                       value="{{ old('feature_card_icon_color', $settings['feature_card_icon_color'] ?? '#173F9E') }}"
                                       oninput="syncColor('txt_feat_icon_color','cp_feat_icon_color')">
                            </div>
                        </div>
                    </div>

                    {{-- Animation toggle switch for Fitur cards --}}
                    <div class="lps-toggle-wrap mb-4">
                        <input type="checkbox"
                               class="lps-toggle"
                               name="features_animation"
                               id="toggle_feat_anim"
                               value="1"
                               {{ ($settings['features_animation'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label for="toggle_feat_anim" style="font-size:0.84rem;font-weight:600;color:#334155;cursor:pointer;margin:0;user-select:none;">
                            Animasi melayang / gerak kartu fitur (Floating Motion)
                        </label>
                    </div>

                    <hr style="border-top:1px dashed #CBD5E1; margin:20px 0;">
                    <span class="lps-label" style="margin-bottom:12px; font-size:0.88rem; color:#173F9E;">Daftar 6 Fitur Utama</span>

                    @for($i = 1; $i <= 6; $i++)
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:14px; margin-bottom:12px;">
                        <div style="font-weight:700; font-size:0.8rem; color:#334155; margin-bottom:8px;">Fitur {{ $i }}</div>
                        <div class="mb-2">
                            <input type="text" class="lps-input" id="inp_f{{ $i }}_title" name="feature_{{ $i }}_title"
                                   value="{{ old('feature_'.$i.'_title', $settings['feature_'.$i.'_title'] ?? '') }}"
                                   placeholder="Judul Fitur {{ $i }}">
                        </div>
                        <div>
                            <textarea class="lps-input" id="inp_f{{ $i }}_desc" name="feature_{{ $i }}_desc" rows="2"
                                      placeholder="Deskripsi Fitur {{ $i }}">{{ old('feature_'.$i.'_desc', $settings['feature_'.$i.'_desc'] ?? '') }}</textarea>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- 6. SECTION BERITA ACARA --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-newspaper"></i> 6 — Section "Berita Acara"</div>
                <div class="lps-section-body">
                    <div class="mb-3">
                        <label class="lps-label">Badge Text</label>
                        <input type="text" class="lps-input" id="inp_berita_badge" name="berita_badge"
                               value="{{ old('berita_badge', $settings['berita_badge'] ?? '') }}"
                               placeholder="Berita Acara">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Section</label>
                        <input type="text" class="lps-input" id="inp_berita_title" name="berita_title"
                               value="{{ old('berita_title', $settings['berita_title'] ?? '') }}"
                               placeholder="Ringkasan Kegiatan Terbaru">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Section</label>
                        <textarea class="lps-input" id="inp_berita_desc" name="berita_description" rows="2"
                                  placeholder="Pantau berita acara terbaru...">{{ old('berita_description', $settings['berita_description'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Teks Tombol Lihat Semua</label>
                        <input type="text" class="lps-input" id="inp_berita_btn" name="berita_btn_text"
                               value="{{ old('berita_btn_text', $settings['berita_btn_text'] ?? '') }}"
                               placeholder="Lihat Semua Berita Acara">
                    </div>
                </div>
            </div>

            {{-- 7. BANNER CTA & FOOTER --}}
            <div class="lps-section-card">
                <div class="lps-section-header"><i class="fas fa-bullhorn"></i> 7 — Banner CTA &amp; Footer</div>
                <div class="lps-section-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Warna Latar Banner CTA</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_cta_bg"
                                       value="{{ old('cta_bg_color', $settings['cta_bg_color'] ?? '#0B1736') }}"
                                       oninput="syncColor('cp_cta_bg','txt_cta_bg')">
                                <input type="text" class="lps-input" id="txt_cta_bg" name="cta_bg_color"
                                       value="{{ old('cta_bg_color', $settings['cta_bg_color'] ?? '#0B1736') }}"
                                       oninput="syncColor('txt_cta_bg','cp_cta_bg')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="lps-label">Warna Latar Footer</label>
                            <div class="color-row">
                                <input type="color" class="color-picker-btn" id="cp_footer_bg"
                                       value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0B1736') }}"
                                       oninput="syncColor('cp_footer_bg','txt_footer_bg')">
                                <input type="text" class="lps-input" id="txt_footer_bg" name="footer_bg_color"
                                       value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0B1736') }}"
                                       oninput="syncColor('txt_footer_bg','cp_footer_bg')">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Judul Banner CTA</label>
                        <input type="text" class="lps-input" id="inp_cta_title" name="cta_title"
                               value="{{ old('cta_title', $settings['cta_title'] ?? '') }}"
                               placeholder="Siap Meningkatkan Efektivitas Audit Internal Anda?">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Banner CTA</label>
                        <textarea class="lps-input" id="inp_cta_desc" name="cta_description" rows="2"
                                  placeholder="Bergabunglah dengan organisasi-organisasi...">{{ old('cta_description', $settings['cta_description'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Teks Tombol Utama CTA</label>
                        <input type="text" class="lps-input" id="inp_cta_btn" name="cta_btn_text"
                               value="{{ old('cta_btn_text', $settings['cta_btn_text'] ?? '') }}"
                               placeholder="Mulai Sekarang">
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Deskripsi Singkat Footer</label>
                        <textarea class="lps-input" id="inp_footer_about" name="footer_about" rows="2"
                                  placeholder="Sistem Informasi Supervisi dan Pengawasan Internal...">{{ old('footer_about', $settings['footer_about'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="lps-label">Teks Hak Cipta / Copyright</label>
                        <input type="text" class="lps-input" id="inp_footer_copyright" name="footer_copyright"
                               value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
                               placeholder="SISPI. Sistem Informasi Supervisi dan Pengawasan Internal. All rights reserved.">
                    </div>
                </div>
            </div>

        </div>{{-- /col-lg-7 --}}

        {{-- ══════════════════════ RIGHT PREVIEW ══════════════════════ --}}
        <div class="col-lg-5">
            <div style="position:sticky;top:80px; max-height: calc(100vh - 100px); overflow-y: auto;">
                <div style="background:#fff;border:1px solid #E2E8F0;border-radius:16px;overflow:hidden;box-shadow:0 4px 18px rgba(11,23,54,0.06);">
                    <div style="background:#0F172A;padding:12px 18px;display:flex;align-items:center;justify-content:space-between; position:sticky; top:0; z-index:10;">
                        <span style="color:#94A3B8;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">
                            <i class="fas fa-eye text-info mr-1"></i> Live Preview Lengkap
                        </span>
                        <div style="display:flex;gap:5px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#EF4444;display:inline-block;"></span>
                            <span style="width:10px;height:10px;border-radius:50%;background:#F59E0B;display:inline-block;"></span>
                            <span style="width:10px;height:10px;border-radius:50%;background:#10B981;display:inline-block;"></span>
                        </div>
                    </div>
                    <div id="prev_bg" style="padding:24px 20px;transition:background 0.3s ease;background:{{ $settings['theme_bg_color'] ?? '#F7F9FC' }}">

                        {{-- 1. Hero Preview --}}
                        <div id="prev_badge" style="display:inline-flex;align-items:center;gap:6px;background:#EAF0FF;border-radius:999px;padding:4px 14px;font-size:0.7rem;font-weight:800;color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;border:1px solid rgba(23,63,158,0.2);">
                            <span id="prev_badge_dot" style="width:5px;height:5px;border-radius:50%;background:{{ $settings['theme_primary_color'] ?? '#173F9E' }};"></span>
                            <span id="prev_badge_text">{{ $settings['hero_badge_text'] ?? 'SISTEM INFORMASI SPI' }}</span>
                        </div>

                        <div id="prev_title" style="font-size:1.25rem;font-weight:800;color:#111827;line-height:1.3;margin-bottom:10px;">
                            {{ $settings['hero_title'] ?? 'Sistem Informasi Supervisi dan Pengawasan Internal' }}
                        </div>

                        <div id="prev_desc" style="font-size:0.8rem;color:#64748B;line-height:1.6;margin-bottom:16px;">
                            {{ $settings['hero_description'] ?? 'Solusi digital terpadu untuk manajemen audit internal.' }}
                        </div>

                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;">
                            <span id="prev_btn1" style="padding:7px 16px;border-radius:8px;font-size:0.78rem;font-weight:700;color:#fff;background:{{ $settings['theme_primary_color'] ?? '#173F9E' }};">
                                {{ $settings['hero_btn_primary_text'] ?? 'Mulai Sekarang →' }}
                            </span>
                            <span id="prev_btn2" style="padding:7px 16px;border-radius:8px;font-size:0.78rem;font-weight:700;border:1.5px solid {{ $settings['theme_primary_color'] ?? '#173F9E' }};color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};">
                                {{ $settings['hero_btn_secondary_text'] ?? 'Pelajari Lebih Lanjut' }}
                            </span>
                        </div>

                        {{-- Card or Image --}}
                        <div id="prev-card-wrap" style="{{ ($settings['hero_display_mode'] ?? 'card') === 'image' ? 'display:none;' : '' }}">
                            <div id="prev-card" class="{{ ($settings['floating_card_animation'] ?? '1') == '1' ? 'anim-on' : '' }}"
                                 style="background:linear-gradient(145deg,{{ $settings['floating_card_gradient_start'] ?? '#2557D6' }},{{ $settings['floating_card_gradient_end'] ?? '#173F9E' }});">
                                <div class="prev-icon-box" id="prev_icon_box" style="color:{{ $settings['floating_card_icon_color'] ?? '#173F9E' }};">
                                    <i id="prev_icon_i" class="{{ $settings['floating_card_icon'] ?? 'fas fa-clipboard-check' }}"></i>
                                </div>
                                <div id="prev_card_title" style="font-size:1rem;font-weight:800;color:#fff;margin-bottom:6px;">
                                    {{ $settings['floating_card_title'] ?? 'Audit Management' }}
                                </div>
                                <div id="prev_card_desc" style="font-size:0.78rem;color:rgba(255,255,255,0.88);line-height:1.55;">
                                    {{ $settings['floating_card_desc'] ?? 'Kelola seluruh proses audit internal dengan sistematis.' }}
                                </div>
                            </div>
                        </div>

                        <div id="prev-image-wrap" style="{{ ($settings['hero_display_mode'] ?? 'card') !== 'image' ? 'display:none;' : '' }}">
                            @if(!empty($settings['hero_image']))
                            <img id="prev_hero_img" src="{{ asset('landing_images/' . $settings['hero_image']) }}"
                                 alt="{{ $settings['hero_image_alt'] ?? '' }}"
                                 style="width:100%;border-radius:14px;object-fit:cover;max-height:200px;box-shadow:0 8px 24px rgba(0,0,0,0.14);">
                            @else
                            <div id="prev_hero_img_placeholder"
                                 style="width:100%;height:140px;border-radius:14px;background:#E2E8F0;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:#94A3B8;">
                                <i class="fas fa-image" style="font-size:2rem;"></i>
                                <span style="font-size:0.75rem;font-weight:600;">Belum ada gambar</span>
                            </div>
                            <img id="prev_hero_img" src="" style="width:100%;border-radius:14px;object-fit:cover;max-height:200px;box-shadow:0 8px 24px rgba(0,0,0,0.14);display:none;">
                            @endif
                        </div>

                        {{-- 2. Preview Section Tentang Kami --}}
                        <div style="margin-top:24px; padding-top:20px; border-top:2px dashed #CBD5E1;">
                            <div style="font-size:0.68rem; font-weight:800; color:#94A3B8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-circle-info" id="prev_about_icon" style="color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};"></i> PREVIEW SECTION TENTANG KAMI
                            </div>

                            <div style="text-align:center; margin-bottom:14px;">
                                <span id="prev_about_badge" style="display:inline-block; padding:3px 12px; background:#EAF0FF; color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; border-radius:999px; font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; border:1px solid rgba(23,63,158,0.2);">
                                    {{ $settings['about_badge'] ?? 'TENTANG KAMI' }}
                                </span>
                                <h4 id="prev_about_title" style="font-size:1.05rem; font-weight:800; color:#111827; margin-top:8px; margin-bottom:6px; line-height:1.3;">
                                    {{ $settings['about_title'] ?? 'Transformasi Digital untuk Audit Internal' }}
                                </h4>
                                <p id="prev_about_desc" style="font-size:0.75rem; color:#64748B; line-height:1.55; margin:0 auto; max-width:95%;">
                                    {{ $settings['about_description'] ?? 'SISPI hadir sebagai solusi komprehensif...' }}
                                </p>
                            </div>

                            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:12px; padding:14px; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                                <h5 id="prev_about_why_title" style="font-size:0.85rem; font-weight:800; color:#111827; margin-bottom:8px;">
                                    {{ $settings['about_why_title'] ?? 'Mengapa Memilih SISPI?' }}
                                </h5>
                                <p id="prev_about_why_p1" style="font-size:0.73rem; color:#64748B; line-height:1.5; margin-bottom:6px;">
                                    {{ $settings['about_why_p1'] ?? 'Sispi dirancang khusus...' }}
                                </p>
                                <p id="prev_about_why_p2" style="font-size:0.73rem; color:#64748B; line-height:1.5; margin-bottom:8px;">
                                    {{ $settings['about_why_p2'] ?? 'Sistem kami mengintegrasikan...' }}
                                </p>

                                {{-- Checklist Items Live Preview --}}
                                <div id="prev-checklist-container" style="border-top:1px dashed #E2E8F0; padding-top:8px; margin-top:8px;">
                                    @foreach($savedChecklists as $cIdx => $cText)
                                    <div style="display:flex; align-items:center; gap:6px; font-size:0.68rem; font-weight:700; color:#111827; margin-bottom:4px;">
                                        <i class="fas fa-check prev_chk_icon" style="color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; font-size:0.7rem;"></i>
                                        <span>{{ $cText }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Prinsip Pengawasan Live Preview --}}
                            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:12px; padding:10px; margin-top:10px;">
                                <div id="prev_about_principles_title" style="font-size:0.75rem; font-weight:800; color:#111827; margin-bottom:8px; text-align:center;">
                                    {{ $settings['about_principles_title'] ?? 'Prinsip Pengawasan Internal' }}
                                </div>
                                @php
                                    $principleIcons = [
                                        1 => 'fas fa-shield',
                                        2 => 'fas fa-eye',
                                        3 => 'fas fa-scale-balanced',
                                        4 => 'fas fa-user-tie',
                                        5 => 'fas fa-bolt',
                                    ];
                                @endphp
                                <div style="display:grid; grid-template-columns:repeat(5, 1fr); gap:4px; text-align:center;">
                                    @for($p = 1; $p <= 5; $p++)
                                    <div style="background:#F7F9FC; border:1px solid #E2E8F0; border-radius:8px; padding:6px 2px;">
                                        <i class="{{ $principleIcons[$p] }} prev_prinsip_icon" style="font-size:0.75rem; color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; margin-bottom:2px; display:block;"></i>
                                        <span id="prev_about_prinsip_{{ $p }}" style="font-size:0.55rem; font-weight:700; color:#111827; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $settings['about_principle_'.$p] ?? ('Prinsip '.$p) }}
                                        </span>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        {{-- 3. Preview Section Fitur --}}
                        <div style="margin-top:24px; padding-top:20px; border-top:2px dashed #CBD5E1;">
                            <div style="font-size:0.68rem; font-weight:800; color:#94A3B8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-grid-2" id="prev_features_icon" style="color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};"></i> PREVIEW FITUR UNGGULAN
                            </div>

                            <div style="text-align:center; margin-bottom:14px;">
                                <span id="prev_features_badge" style="display:inline-block; padding:3px 12px; background:#EAF0FF; color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; border-radius:999px; font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; border:1px solid rgba(23,63,158,0.2);">
                                    {{ $settings['features_badge'] ?? 'FITUR UNGGULAN' }}
                                </span>
                                <h4 id="prev_features_title" style="font-size:1.05rem; font-weight:800; color:#111827; margin-top:8px; margin-bottom:6px; line-height:1.3;">
                                    {{ $settings['features_title'] ?? 'Fitur Lengkap untuk Audit yang Efektif' }}
                                </h4>
                                <p id="prev_features_desc" style="font-size:0.75rem; color:#64748B; line-height:1.55; margin:0 auto; max-width:95%;">
                                    {{ $settings['features_description'] ?? 'Berbagai fitur canggih yang dirancang untuk mendukung setiap tahapan proses audit internal Anda.' }}
                                </p>
                            </div>

                            @php
                                $featureIcons = [
                                    1 => 'fas fa-clipboard-check',
                                    2 => 'fas fa-chart-pie',
                                    3 => 'fas fa-file-signature',
                                    4 => 'fas fa-users-gear',
                                    5 => 'fas fa-clipboard-list',
                                    6 => 'fas fa-lock',
                                ];
                            @endphp
                            <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:8px;">
                                @for($i = 1; $i <= 6; $i++)
                                <div class="prev_feat_card {{ ($settings['features_animation'] ?? '1') == '1' ? 'anim-on' : '' }}" style="background:linear-gradient(145deg, {{ $settings['feature_card_gradient_start'] ?? '#2557D6' }}, {{ $settings['feature_card_gradient_end'] ?? '#173F9E' }}); border-radius:10px; padding:10px; color:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.08);">
                                    <div class="prev_f_icon" style="width:24px; height:24px; background:#FFFFFF; border-radius:6px; color:{{ $settings['feature_card_icon_color'] ?? '#173F9E' }}; display:flex; align-items:center; justify-content:center; font-size:0.75rem; margin-bottom:6px;">
                                        <i class="{{ $featureIcons[$i] }}"></i>
                                    </div>
                                    <h6 id="prev_f{{ $i }}_title" style="font-size:0.75rem; font-weight:700; color:#fff; margin-bottom:3px; line-height:1.2;">
                                        {{ $settings['feature_'.$i.'_title'] ?? 'Fitur '.$i }}
                                    </h6>
                                    <p id="prev_f{{ $i }}_desc" style="font-size:0.65rem; color:rgba(255,255,255,0.85); line-height:1.4; margin:0; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                                        {{ $settings['feature_'.$i.'_desc'] ?? 'Deskripsi fitur...' }}
                                    </p>
                                </div>
                                @endfor
                            </div>
                        </div>

                        {{-- 4. Preview Section Berita Acara --}}
                        <div style="margin-top:24px; padding-top:20px; border-top:2px dashed #CBD5E1;">
                            <div style="font-size:0.68rem; font-weight:800; color:#94A3B8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-newspaper" id="prev_berita_icon" style="color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};"></i> PREVIEW BERITA ACARA
                            </div>

                            <div style="text-align:center; margin-bottom:14px;">
                                <span id="prev_berita_badge" style="display:inline-block; padding:3px 12px; background:#EAF0FF; color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; border-radius:999px; font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; border:1px solid rgba(23,63,158,0.2);">
                                    {{ $settings['berita_badge'] ?? 'Berita Acara' }}
                                </span>
                                <h4 id="prev_berita_title" style="font-size:1.05rem; font-weight:800; color:#111827; margin-top:8px; margin-bottom:6px; line-height:1.3;">
                                    {{ $settings['berita_title'] ?? 'Ringkasan Kegiatan Terbaru' }}
                                </h4>
                                <p id="prev_berita_desc" style="font-size:0.75rem; color:#64748B; line-height:1.55; margin:0 auto; max-width:95%;">
                                    {{ $settings['berita_description'] ?? 'Pantau berita acara terbaru lengkap dengan dokumentasi rapat dan bukti visual.' }}
                                </p>
                            </div>

                            <div style="text-align:center; margin-top:12px;">
                                <span id="prev_berita_btn" style="display:inline-block; padding:6px 16px; border-radius:8px; font-size:0.75rem; font-weight:700; color:#fff; background:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; box-shadow:0 2px 8px rgba(23,63,158,0.2);">
                                    {{ $settings['berita_btn_text'] ?? 'Lihat Semua Berita Acara' }} <i class="fas fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>

                        {{-- 5. Preview Banner CTA & Footer --}}
                        <div style="margin-top:24px; padding-top:20px; border-top:2px dashed #CBD5E1;">
                            <div style="font-size:0.68rem; font-weight:800; color:#94A3B8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-bullhorn" id="prev_cta_icon" style="color:{{ $settings['theme_primary_color'] ?? '#173F9E' }};"></i> PREVIEW BANNER CTA &amp; FOOTER
                            </div>

                            {{-- CTA Banner --}}
                            <div id="prev_cta_box" style="background:{{ $settings['cta_bg_color'] ?? '#0B1736' }}; border-radius:14px; padding:18px 16px; text-align:center; color:#fff; margin-bottom:14px;">
                                <h5 id="prev_cta_title" style="font-size:0.95rem; font-weight:800; margin-bottom:6px; color:#fff;">
                                    {{ $settings['cta_title'] ?? 'Siap Meningkatkan Efektivitas Audit Internal Anda?' }}
                                </h5>
                                <p id="prev_cta_desc" style="font-size:0.72rem; color:rgba(255,255,255,0.8); line-height:1.4; margin-bottom:12px;">
                                    {{ $settings['cta_description'] ?? 'Bergabunglah dengan organisasi-organisasi yang telah mempercayai SISPI...' }}
                                </p>
                                <span id="prev_cta_btn" style="display:inline-block; padding:6px 16px; background:#fff; color:{{ $settings['theme_primary_color'] ?? '#173F9E' }}; font-weight:800; font-size:0.75rem; border-radius:8px;">
                                    {{ $settings['cta_btn_text'] ?? 'Mulai Sekarang' }}
                                </span>
                            </div>

                            {{-- Footer --}}
                            <div id="prev_footer_box" style="background:{{ $settings['footer_bg_color'] ?? '#0B1736' }}; border-radius:14px; padding:16px; color:#fff;">
                                <h6 style="font-weight:800; color:#fff; font-size:0.85rem; margin-bottom:6px;">SISPI</h6>
                                <p id="prev_footer_about" style="font-size:0.7rem; color:rgba(255,255,255,0.75); line-height:1.4; margin-bottom:10px;">
                                    {{ $settings['footer_about'] ?? 'Sistem Informasi Supervisi dan Pengawasan Internal...' }}
                                </p>
                                <div id="prev_footer_copyright" style="font-size:0.65rem; color:rgba(255,255,255,0.5); border-top:1px solid rgba(255,255,255,0.1); padding-top:8px;">
                                    &copy; {{ date('Y') }} {{ $settings['footer_copyright'] ?? 'SISPI. Sistem Informasi Supervisi dan Pengawasan Internal. All rights reserved.' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:12px;padding:12px 16px;margin-top:16px;">
                    <p style="font-size:0.78rem;color:#1D4ED8;margin:0;font-weight:500;">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Preview diperbarui <strong>realtime</strong>. Klik <em>Simpan Perubahan</em> untuk menyimpan ke database.
                    </p>
                </div>
            </div>
        </div>

    </div>{{-- /row --}}

    {{-- STICKY SAVE BAR --}}
    <div class="save-bar">
        <a href="{{ url('/dashboard') }}"
           style="padding:9px 22px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:0.85rem;font-weight:600;color:#64748B;text-decoration:none;background:#fff;">
            Batal
        </a>
        <button type="submit" form="lpsForm"
                style="padding:9px 28px;background:linear-gradient(135deg,#173F9E,#2557D6);color:#fff;border:none;border-radius:10px;font-size:0.875rem;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(23,63,158,0.3);">
            <i class="fas fa-save mr-1"></i> Simpan Perubahan
        </button>
    </div>

    </form>
</section>
</div>
@endsection

@push('scripts')
<script>
/* ═══════════════════════════════════════════════
   Sync color picker <-> text input
═══════════════════════════════════════════════ */
function syncColor(srcId, dstId) {
    document.getElementById(dstId).value = document.getElementById(srcId).value;
    refreshPreview();
}

/* ═══════════════════════════════════════════════
   Full realtime preview refresh
═══════════════════════════════════════════════ */
function refreshPreview() {
    var primary   = document.getElementById('txt_primary').value    || '#173F9E';
    var bg        = document.getElementById('txt_bg').value         || '#F7F9FC';
    var gradStart = document.getElementById('txt_grad_start') ? (document.getElementById('txt_grad_start').value || '#2557D6') : '#2557D6';
    var gradEnd   = document.getElementById('txt_grad_end')   ? (document.getElementById('txt_grad_end').value   || '#173F9E') : '#173F9E';
    var iconColor = document.getElementById('txt_icon_color') ? (document.getElementById('txt_icon_color').value || '#173F9E') : '#173F9E';

    /* BG */
    document.getElementById('prev_bg').style.background = bg;

    /* Primary Color for all badges, icons & primary buttons in Preview */
    ['prev_badge', 'prev_about_badge', 'prev_features_badge', 'prev_berita_badge'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.color = primary;
    });

    ['prev_badge_dot'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.background = primary;
    });

    ['prev_about_icon', 'prev_features_icon', 'prev_berita_icon', 'prev_cta_icon'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.color = primary;
    });

    /* Hero Text & Buttons */
    var badgeEl = document.getElementById('inp_badge');
    document.getElementById('prev_badge_text').innerText = badgeEl ? (badgeEl.value || 'SISTEM INFORMASI SPI') : 'SISTEM INFORMASI SPI';

    var titleEl = document.getElementById('inp_title');
    document.getElementById('prev_title').innerText = titleEl ? (titleEl.value || 'Sistem Informasi Supervisi dan Pengawasan Internal') : '';

    var descEl = document.getElementById('inp_desc');
    document.getElementById('prev_desc').innerText = descEl ? (descEl.value || '') : '';

    document.getElementById('prev_btn1').style.background = primary;
    var btn1El = document.getElementById('inp_btn1');
    document.getElementById('prev_btn1').innerText = btn1El ? (btn1El.value || 'Mulai Sekarang →') : 'Mulai Sekarang →';

    document.getElementById('prev_btn2').style.borderColor = primary;
    document.getElementById('prev_btn2').style.color = primary;
    var btn2El = document.getElementById('inp_btn2');
    document.getElementById('prev_btn2').innerText = btn2El ? (btn2El.value || 'Pelajari Lebih Lanjut') : 'Pelajari Lebih Lanjut';

    /* Card gradient */
    var cardEl = document.getElementById('prev-card');
    if (cardEl) {
        cardEl.style.background = 'linear-gradient(145deg,' + gradStart + ',' + gradEnd + ')';
    }

    var ctEl = document.getElementById('inp_card_title');
    var cdEl = document.getElementById('inp_card_desc');
    if (document.getElementById('prev_card_title') && ctEl)
        document.getElementById('prev_card_title').innerText = ctEl.value || 'Audit Management';
    if (document.getElementById('prev_card_desc') && cdEl)
        document.getElementById('prev_card_desc').innerText = cdEl.value || '';

    /* Icon */
    var iconEl = document.getElementById('inp_icon');
    if (iconEl) {
        var iconClass = iconEl.value || 'fas fa-clipboard-check';
        document.getElementById('prev_icon_i').className = iconClass;
        document.getElementById('icon_preview').querySelector('i').className = iconClass;
    }
    var pib = document.getElementById('prev_icon_box');
    if (pib) pib.style.color = iconColor;

    /* Animation toggle */
    var animChk = document.getElementById('toggle_anim');
    if (cardEl && animChk) {
        if (animChk.checked) {
            cardEl.classList.add('anim-on');
        } else {
            cardEl.classList.remove('anim-on');
        }
    }

    /* Section 4: Tentang Kami Sync */
    var abEl = document.getElementById('inp_about_badge');
    if (document.getElementById('prev_about_badge') && abEl) {
        document.getElementById('prev_about_badge').innerText = abEl.value || 'TENTANG KAMI';
    }

    var atEl = document.getElementById('inp_about_title');
    if (document.getElementById('prev_about_title') && atEl) {
        document.getElementById('prev_about_title').innerText = atEl.value || 'Transformasi Digital untuk Audit Internal';
    }

    var adEl = document.getElementById('inp_about_desc');
    if (document.getElementById('prev_about_desc') && adEl) {
        document.getElementById('prev_about_desc').innerText = adEl.value || '';
    }

    var awtEl = document.getElementById('inp_about_why_title');
    if (document.getElementById('prev_about_why_title') && awtEl) {
        document.getElementById('prev_about_why_title').innerText = awtEl.value || 'Mengapa Memilih SISPI?';
    }

    var awp1El = document.getElementById('inp_about_why_p1');
    if (document.getElementById('prev_about_why_p1') && awp1El) {
        document.getElementById('prev_about_why_p1').innerText = awp1El.value || '';
    }

    var awp2El = document.getElementById('inp_about_why_p2');
    if (document.getElementById('prev_about_why_p2') && awp2El) {
        document.getElementById('prev_about_why_p2').innerText = awp2El.value || '';
    }

    /* Dynamic Checklist Items Live Sync */
    var prevChkWrap = document.getElementById('prev-checklist-container');
    if (prevChkWrap) {
        var chkInputs = document.querySelectorAll('#checklist-container .chk-input-field');
        var chkHtml = '';
        chkInputs.forEach(function(inp) {
            var val = inp.value.trim();
            if (val !== '') {
                chkHtml += '<div style="display:flex; align-items:center; gap:6px; font-size:0.68rem; font-weight:700; color:#111827; margin-bottom:4px;">' +
                           '<i class="fas fa-check prev_chk_icon" style="color:' + primary + '; font-size:0.7rem;"></i>' +
                           '<span>' + val.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</span>' +
                           '</div>';
            }
        });
        prevChkWrap.innerHTML = chkHtml;
    }

    var prTitleInp = document.getElementById('inp_about_principles_title');
    var prTitlePrev = document.getElementById('prev_about_principles_title');
    if (prTitlePrev && prTitleInp) prTitlePrev.innerText = prTitleInp.value || 'Prinsip Pengawasan Internal';

    for (var p = 1; p <= 5; p++) {
        var prInp = document.getElementById('inp_about_principle_' + p);
        var prPrev = document.getElementById('prev_about_prinsip_' + p);
        if (prPrev && prInp) prPrev.innerText = prInp.value || ('Prinsip ' + p);
    }

    document.querySelectorAll('.prev_chk_icon, .prev_prinsip_icon').forEach(function(icon) {
        icon.style.color = primary;
    });

    /* Section 5: Fitur Sync & Feature Card Gradient/Icon Color Sync & Animation Sync */
    var featStart   = document.getElementById('txt_feat_grad_start') ? (document.getElementById('txt_feat_grad_start').value || '#2557D6') : '#2557D6';
    var featEnd     = document.getElementById('txt_feat_grad_end')   ? (document.getElementById('txt_feat_grad_end').value   || '#173F9E') : '#173F9E';
    var featIcon    = document.getElementById('txt_feat_icon_color') ? (document.getElementById('txt_feat_icon_color').value || '#173F9E') : '#173F9E';
    var featAnimChk = document.getElementById('toggle_feat_anim');

    document.querySelectorAll('.prev_feat_card').forEach(function(card) {
        card.style.background = 'linear-gradient(145deg,' + featStart + ',' + featEnd + ')';
        if (featAnimChk && featAnimChk.checked) {
            card.classList.add('anim-on');
        } else {
            card.classList.remove('anim-on');
        }
    });
    document.querySelectorAll('.prev_f_icon').forEach(function(icon) {
        icon.style.color = featIcon;
    });

    var fbEl = document.getElementById('inp_features_badge');
    if (document.getElementById('prev_features_badge') && fbEl) {
        document.getElementById('prev_features_badge').innerText = fbEl.value || 'FITUR UNGGULAN';
    }
    var ftEl = document.getElementById('inp_features_title');
    if (document.getElementById('prev_features_title') && ftEl) {
        document.getElementById('prev_features_title').innerText = ftEl.value || 'Fitur Lengkap untuk Audit yang Efektif';
    }
    var fdEl = document.getElementById('inp_features_desc');
    if (document.getElementById('prev_features_desc') && fdEl) {
        document.getElementById('prev_features_desc').innerText = fdEl.value || '';
    }

    for (var i = 1; i <= 6; i++) {
        var fTitleInput = document.getElementById('inp_f' + i + '_title');
        var fDescInput  = document.getElementById('inp_f' + i + '_desc');
        var fTitlePrev  = document.getElementById('prev_f' + i + '_title');
        var fDescPrev   = document.getElementById('prev_f' + i + '_desc');
        if (fTitlePrev && fTitleInput) fTitlePrev.innerText = fTitleInput.value || ('Fitur ' + i);
        if (fDescPrev && fDescInput)   fDescPrev.innerText  = fDescInput.value  || '';
    }

    /* Section 6: Berita Acara Sync */
    var bbEl = document.getElementById('inp_berita_badge');
    if (document.getElementById('prev_berita_badge') && bbEl) {
        document.getElementById('prev_berita_badge').innerText = bbEl.value || 'Berita Acara';
    }
    var btEl = document.getElementById('inp_berita_title');
    if (document.getElementById('prev_berita_title') && btEl) {
        document.getElementById('prev_berita_title').innerText = btEl.value || 'Ringkasan Kegiatan Terbaru';
    }
    var bdEl = document.getElementById('inp_berita_desc');
    if (document.getElementById('prev_berita_desc') && bdEl) {
        document.getElementById('prev_berita_desc').innerText = bdEl.value || '';
    }
    var bbtnEl = document.getElementById('inp_berita_btn');
    if (document.getElementById('prev_berita_btn') && bbtnEl) {
        document.getElementById('prev_berita_btn').innerText = bbtnEl.value || 'Lihat Semua Berita Acara';
        document.getElementById('prev_berita_btn').style.background = primary;
    }

    /* Section 7: Banner CTA & Footer Background Colors Sync */
    var ctaBg    = document.getElementById('txt_cta_bg')    ? (document.getElementById('txt_cta_bg').value    || '#0B1736') : '#0B1736';
    var footerBg = document.getElementById('txt_footer_bg') ? (document.getElementById('txt_footer_bg').value || '#0B1736') : '#0B1736';

    if (document.getElementById('prev_cta_box'))    document.getElementById('prev_cta_box').style.background = ctaBg;
    if (document.getElementById('prev_footer_box')) document.getElementById('prev_footer_box').style.background = footerBg;

    var ctatEl = document.getElementById('inp_cta_title');
    if (document.getElementById('prev_cta_title') && ctatEl) {
        document.getElementById('prev_cta_title').innerText = ctatEl.value || '';
    }
    var ctadEl = document.getElementById('inp_cta_desc');
    if (document.getElementById('prev_cta_desc') && ctadEl) {
        document.getElementById('prev_cta_desc').innerText = ctadEl.value || '';
    }
    var ctabEl = document.getElementById('inp_cta_btn');
    if (document.getElementById('prev_cta_btn') && ctabEl) {
        document.getElementById('prev_cta_btn').innerText = ctabEl.value || 'Mulai Sekarang';
        document.getElementById('prev_cta_btn').style.color = primary;
    }

    var faEl = document.getElementById('inp_footer_about');
    if (document.getElementById('prev_footer_about') && faEl) {
        document.getElementById('prev_footer_about').innerText = faEl.value || '';
    }
    var fcEl = document.getElementById('inp_footer_copyright');
    if (document.getElementById('prev_footer_copyright') && fcEl) {
        document.getElementById('prev_footer_copyright').innerText = '© ' + new Date().getFullYear() + ' ' + (fcEl.value || 'SISPI. All rights reserved.');
    }
}

/* ═══════════════════════════════════════════════
   Hero display mode switch (card / image)
═══════════════════════════════════════════════ */
function applyDisplayMode(mode) {
    var cardFields  = document.getElementById('card-fields');
    var imageFields = document.getElementById('image-fields');
    var prevCard    = document.getElementById('prev-card-wrap');
    var prevImg     = document.getElementById('prev-image-wrap');

    if (mode === 'card') {
        cardFields.classList.remove('hidden');
        imageFields.classList.add('hidden');
        prevCard.style.display = '';
        prevImg.style.display  = 'none';
    } else {
        cardFields.classList.add('hidden');
        imageFields.classList.remove('hidden');
        prevCard.style.display = 'none';
        prevImg.style.display  = '';
    }
}

document.querySelectorAll('input[name="hero_display_mode"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        applyDisplayMode(this.value);
    });
});

/* ═══════════════════════════════════════════════
   Image upload preview
═══════════════════════════════════════════════ */
function previewUpload(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var src = e.target.result;
        document.getElementById('upload-preview-img').src = src;
        document.getElementById('upload-preview-wrap').style.display = 'block';
        document.getElementById('upload-text').innerText = input.files[0].name;
        var prevHeroImg = document.getElementById('prev_hero_img');
        if (prevHeroImg) {
            prevHeroImg.src = src;
            prevHeroImg.style.display = 'block';
            var placeholder = document.getElementById('prev_hero_img_placeholder');
            if (placeholder) placeholder.style.display = 'none';
        }
    };
    reader.readAsDataURL(input.files[0]);
}

function clearUpload() {
    document.getElementById('hero_image_input').value = '';
    document.getElementById('upload-preview-wrap').style.display = 'none';
    document.getElementById('upload-text').innerText = 'Klik atau seret gambar ke sini';
    var prev = document.getElementById('prev_hero_img');
    if (prev) { prev.src = ''; prev.style.display = 'none'; }
    var ph = document.getElementById('prev_hero_img_placeholder');
    if (ph) ph.style.display = 'flex';
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('uploadZone').classList.remove('drag-over');
    var file = event.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    var dt = new DataTransfer();
    dt.items.add(file);
    var inp = document.getElementById('hero_image_input');
    inp.files = dt.files;
    previewUpload(inp);
}

/* ═══════════════════════════════════════════════
   Attach all inputs → refreshPreview
═══════════════════════════════════════════════ */
document.querySelectorAll('#lpsForm input:not([type="file"]), #lpsForm textarea').forEach(function(el) {
    el.addEventListener('input', refreshPreview);
    el.addEventListener('change', refreshPreview);
});

function addChecklistItem(text) {
    text = text || '';
    var container = document.getElementById('checklist-container');
    if (!container) return;
    var div = document.createElement('div');
    div.className = 'd-flex align-items-center gap-2 mb-2 checklist-item-row';
    div.innerHTML = '<input type="text" class="lps-input flex-fill chk-input-field" name="about_checklists[]" value="' + text.replace(/"/g, '&quot;') + '" placeholder="Tulis poin checklist..." oninput="refreshPreview()">' +
                    '<button type="button" class="btn btn-outline-danger btn-sm rounded-lg" onclick="removeChecklistItem(this)" style="padding:7px 12px; border-radius:10px; flex-shrink:0;"><i class="fas fa-trash-can"></i></button>';
    container.appendChild(div);
    refreshPreview();
}

function removeChecklistItem(btn) {
    var row = btn.closest('.checklist-item-row');
    if (row) {
        row.remove();
        refreshPreview();
    }
}

/* Run once on page load */
refreshPreview();
</script>
@endpush
