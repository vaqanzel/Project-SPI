@extends('layout.app')
@section('title', 'Berita Acara')

@php($isWelcomePage = true)

@push('style')
    <link rel="stylesheet" href="{{ asset('css/sispi-theme.css') }}">
    <style>
        body {
            background: #F7F9FC;
        }

        #app .main-wrapper {
            display: block;
            padding-left: 0;
        }

        .main-footer {
            margin-left: 0;
        }

        .welcome-berita-hero {
            background: linear-gradient(135deg, #0B1736 0%, #173F9E 100%);
            color: #FFFFFF;
            padding: 125px 0 70px;
            position: relative;
        }

        .search-filter-card {
            background: #FFFFFF;
            border-radius: 18px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 30px rgba(11, 23, 54, 0.06);
            padding: 28px;
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }

        .search-input-field {
            height: 48px;
            padding-left: 44px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            background: #F7F9FC;
            font-size: 0.95rem;
            width: 100%;
        }

        .search-input-field:focus {
            background: #FFFFFF;
            border-color: #173F9E;
            box-shadow: 0 0 0 4px rgba(23, 63, 158, 0.1);
            outline: none;
        }

        .filter-chip-btn {
            padding: 8px 22px;
            border-radius: 999px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            color: #64748B;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-chip-btn:hover, .filter-chip-btn.active {
            background: #173F9E;
            color: #FFFFFF;
            border-color: #173F9E;
        }
    </style>
@endpush

@section('main')
    <div class="welcome-berita-wrapper">
        <!-- Hero Section -->
        <header class="welcome-berita-hero">
            <div class="sispi-container text-center">
                <span class="sispi-badge sispi-badge-gold mb-3">Berita Acara</span>
                <h1 style="font-size: 2.75rem; font-weight: 800; color: #ffffff; margin-bottom: 12px;">Ringkasan Kegiatan</h1>
                <p style="font-size: 1.1rem; color: #CBD5E1; max-width: 640px; margin: 0 auto 24px;">
                    Pantau berita acara terbaru lengkap dengan dokumentasi rapat dan bukti visual.
                </p>
                <a href="{{ url('/') }}" class="sispi-btn sispi-btn-outline" style="border-color: rgba(255,255,255,0.4); color: #ffffff !important; padding: 8px 20px;">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </header>

        <!-- Search & Content Section -->
        <main class="py-5">
            <div class="sispi-container">
                <!-- Search Bar & Filter Chips -->
                <div class="search-filter-card mb-5">
                    <form method="GET" action="{{ route('welcome.berita-acara') }}">
                        <div class="form-row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="search-input-wrapper">
                                    <i class="fas fa-search"></i>
                                    <input id="search" type="text" name="search" class="search-input-field"
                                           value="{{ $filters['search'] ?? '' }}" placeholder="Cari berita acara...">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <input id="start_date" type="date" name="start_date" class="form-control" style="height: 48px; border-radius: 12px;"
                                       value="{{ $filters['start_date'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group w-100">
                                    <button type="submit" class="sispi-btn sispi-btn-primary flex-fill" style="padding: 10px;">
                                        Cari
                                    </button>
                                    <a href="{{ route('welcome.berita-acara') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3" style="border-radius: 12px;">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 3-Column Desktop Grid -->
                <div class="row">
                    @forelse ($minutes as $minute)
                        <div class="col-md-6 col-lg-4 mb-4">
                            @include('components.minute-card', ['minute' => $minute])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center p-5 rounded-lg" role="alert">
                                <i class="fas fa-folder-open text-3xl mb-2 d-block"></i>
                                Tidak menemukan berita acara sesuai filter yang dipilih.
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($minutes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $minutes->appends($filters ?? [])->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    @include('components.minute-card-script')
@endpush
