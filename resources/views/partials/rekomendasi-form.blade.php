{{-- ════════════════════════════════════════════════════════════════
     RTM Partial Form — dipakai di tindakLanjut/create.blade.php
     Semua name, variable ($index, $rtm) dipertahankan 100%
════════════════════════════════════════════════════════════════ --}}
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
                <textarea name="rtm[{{ $index }}][temuan]"
                          class="spi-form-control"
                          rows="3"
                          placeholder="Masukkan temuan audit...">{{ $rtm->temuan ?? '' }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="spi-form-group">
                <label class="spi-form-label" style="font-size:0.8rem;">Rekomendasi</label>
                <textarea name="rtm[{{ $index }}][rekomendasi]"
                          class="spi-form-control"
                          rows="3"
                          placeholder="Masukkan rekomendasi tindak lanjut...">{{ $rtm->rekomendasi ?? '' }}</textarea>
            </div>
        </div>
    </div>

</div>