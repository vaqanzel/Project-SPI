@php
    $minuteImages = collect($minute->images ?? []);
    $minuteDocuments = collect($minute->documents ?? []);
    $firstImage = $minuteImages->first();
    $modalId = 'minuteModal-' . ($minute->id ?? uniqid());
    $hasImages = $minuteImages->isNotEmpty() && !empty($firstImage->image_url);
@endphp

<article class="minute-interactive-card w-100 h-100 d-flex flex-column" data-minute-card style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 20px rgba(11, 23, 54, 0.04); transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
    @if ($hasImages)
        <!-- Top Dynamic Image Section (Only rendered if image exists in DB) -->
        <div style="position: relative; width: 100%; height: 195px; background: #F1F5F9; overflow: hidden;">
            <img src="{{ $firstImage->image_url }}" alt="{{ $firstImage->caption ?? $minute->title }}"
                style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease;">
        </div>
    @endif

    <div class="p-4 d-flex flex-column flex-fill">
        <!-- Dynamic Date -->
        <div style="color: #64748B; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">
            {{ $minute->meeting_date?->format('d M Y') ?? '27 Jul 2026' }}
        </div>

        <!-- Dynamic Title -->
        <h3 style="font-size: 1.15rem; font-weight: 800; color: #111827; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            {{ $minute->title }}
        </h3>

        <!-- Dynamic Summary -->
        @if ($minute->summary)
            <p style="color: #64748B; font-size: 0.875rem; line-height: 1.6; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $minute->summary }}
            </p>
        @endif

        <!-- Bottom Action Row -->
        <div class="mt-auto pt-3 d-flex align-items-center justify-content-between">
            <div>
                @if ($minuteDocuments->isNotEmpty())
                    <a href="{{ $minuteDocuments->first()->download_url }}" target="_blank" rel="noopener" class="d-inline-flex align-items-center gap-2 px-3 py-2 text-decoration-none" style="background: #F8FAFC; border: 1px solid #E2E8F0; color: var(--theme-primary, #173F9E); font-size: 0.8rem; font-weight: 700; border-radius: 10px; transition: all 0.2s ease;">
                        <i class="fas fa-paperclip" style="color: #94A3B8;"></i>
                        <span>Dokumen PDF</span>
                    </a>
                @endif
            </div>

            <button type="button" class="btn btn-link p-0 text-decoration-none font-weight-bold" data-toggle="modal" data-target="#{{ $modalId }}" style="color: var(--theme-primary, #173F9E); font-size: 0.875rem; font-weight: 700;">
                <span>Lihat Detail →</span>
            </button>
        </div>
    </div>
</article>

<!-- Modal Detail Berita Acara -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 24px; overflow: hidden; border: none; box-shadow: 0 24px 60px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--theme-dark, #0B1736) 0%, var(--theme-primary, #173F9E) 100%); color: #ffffff; padding: 24px 32px; border: none;">
                <div>
                    <span class="badge badge-warning text-dark font-weight-bold uppercase mb-2" style="background: #F4A623; font-size: 0.75rem; padding: 4px 10px; border-radius: 999px;">Berita Acara Kegiatan</span>
                    <h5 class="modal-title h5 font-weight-bold text-white mb-0" id="{{ $modalId }}Label">{{ $minute->title }}</h5>
                </div>
                <button type="button" class="close text-white opacity-100" data-dismiss="modal" aria-label="Close" style="opacity: 1; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.8rem;">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-4" style="background: #F7F9FC;">
                <div class="d-flex flex-wrap gap-3 mb-3 font-weight-600" style="font-size: 0.9rem;">
                    <span style="color: var(--theme-primary, #173F9E); background: #EAF0FF; padding: 4px 14px; border-radius: 999px; border: 1px solid rgba(23,63,158,0.15);">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $minute->meeting_date?->format('d F Y') ?? 'Tanggal N/A' }}
                    </span>
                    @if ($minute->location)
                        <span style="color: #64748B; background: #FFFFFF; padding: 4px 14px; border-radius: 999px; border: 1px solid #E2E8F0;">
                            <i class="fas fa-location-dot mr-1" style="color: #EF4444;"></i> {{ $minute->location }}
                        </span>
                    @endif
                </div>

                <div class="p-4 bg-white rounded-20 border mb-4" style="border-radius: 16px;">
                    <h6 class="font-weight-bold text-dark mb-2" style="font-size: 1rem;"><i class="fas fa-align-left mr-2" style="color: var(--theme-primary, #173F9E);"></i> Ringkasan Kegiatan Audit</h6>
                    <p class="text-muted mb-0" style="line-height: 1.75; font-size: 0.95rem;">
                        {{ $minute->summary ?? 'Tidak ada ringkasan tertulis.' }}
                    </p>
                </div>

                @if ($minuteDocuments->isNotEmpty())
                    <div class="mb-2">
                        <h6 class="font-weight-bold text-dark mb-3" style="font-size: 1rem;"><i class="fas fa-file-pdf text-danger mr-2"></i> Dokumen Lampiran PDF</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($minuteDocuments as $document)
                                <a href="{{ $document->download_url }}" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-between p-3 bg-white rounded border text-decoration-none shadow-sm transition-all" style="border-radius: 14px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 40px; height: 40px; background: #FEE2E2; border-radius: 10px; color: #EF4444; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">{{ $document->file_name }}</div>
                                            <div class="text-muted" style="font-size: 0.8rem;">Dokumen Laporan Resmi SPI</div>
                                        </div>
                                    </div>
                                    <span class="btn btn-sm text-white rounded-pill px-3" style="background: var(--theme-primary, #173F9E) !important; font-size: 0.8rem; font-weight: 700;"><i class="fas fa-download mr-1"></i> Unduh PDF</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-white border-top p-3 px-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal" style="font-weight: 700; font-size: 0.875rem;">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>
