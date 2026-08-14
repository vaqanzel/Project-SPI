<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISPI - Sistem Informasi Supervisi dan Pengawasan Internal | Politeknik Negeri Malang</title>
    <meta name="description" content="Portal resmi Sistem Informasi Supervisi dan Pengawasan Internal (SISPI) Satuan Pengawas Internal Politeknik Negeri Malang. Solusi digital terintegrasi pengawasan internal, audit, peta risiko, dan monitoring.">

    <!-- Google Font Inter & FontAwesome 6 -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS & Theme -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sispi-theme.css') }}">

    <style>
        /* ── Dynamic Theme Variables (Super Admin configurable) ── */
        :root {
            --theme-primary:           {{ $landingSettings['theme_primary_color']           ?? '#173F9E' }};
            --theme-secondary:         {{ $landingSettings['theme_secondary_color']          ?? '#F4A623' }};
            --theme-bg:                {{ $landingSettings['theme_bg_color']                 ?? '#F7F9FC' }};
            --theme-dark:              {{ $landingSettings['theme_dark_bg']                  ?? '#0B1736' }};
            --card-grad-start:         {{ $landingSettings['floating_card_gradient_start']   ?? '#2557D6' }};
            --card-grad-end:           {{ $landingSettings['floating_card_gradient_end']     ?? '#173F9E' }};
            --card-icon-color:         {{ $landingSettings['floating_card_icon_color']       ?? '#173F9E' }};
            --feature-card-start:     {{ $landingSettings['feature_card_gradient_start']  ?? '#2557D6' }};
            --feature-card-end:       {{ $landingSettings['feature_card_gradient_end']    ?? '#173F9E' }};
            --feature-card-icon-color:{{ $landingSettings['feature_card_icon_color']      ?? '#173F9E' }};
            --cta-bg-color:           {{ $landingSettings['cta_bg_color']                ?? '#0B1736' }};
            --footer-bg-color:        {{ $landingSettings['footer_bg_color']             ?? '#0B1736' }};

            /* Override SISPI Design System Root Variables */
            --sispi-primary: var(--theme-primary);
            --sispi-primary-hover: var(--theme-primary);
            --sispi-secondary: var(--theme-dark);
            --sispi-accent: var(--theme-secondary);
            --sispi-bg: var(--theme-bg);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--theme-bg);
            color: #111827;
            overflow-x: hidden;
        }

        /* ----------------------------------------------------
           Navbar Global (Height ~72px)
        ---------------------------------------------------- */
        nav.sispi-navbar-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid #E2E8F0;
            z-index: 1000;
            height: 72px;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        nav.sispi-navbar-sticky.scrolled {
            box-shadow: 0 4px 20px rgba(11, 23, 54, 0.08);
            background: rgba(255, 255, 255, 0.98);
        }

        .nav-inner {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
        }

        .nav-brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-brand-logo img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .nav-brand-text {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--theme-primary);
            letter-spacing: -0.01em;
        }

        .nav-menu-list {
            display: flex;
            gap: 36px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item-link {
            text-decoration: none !important;
            color: #475569;
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            padding: 8px 0;
            transition: color 0.2s ease;
        }

        .nav-item-link:hover, .nav-item-link.active {
            color: var(--theme-primary);
        }

        /* Active Indicator Underline */
        .nav-item-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: var(--theme-primary);
            border-radius: 4px;
            transition: width 0.25s ease;
        }

        .nav-item-link:hover::after, .nav-item-link.active::after {
            width: 100%;
        }

        .nav-btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-nav-masuk {
            padding: 9px 22px;
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary) !important;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 12px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            background: transparent;
        }

        .btn-nav-masuk:hover {
            background: var(--theme-primary);
            color: #FFFFFF !important;
            transform: scale(1.02);
        }

        .btn-nav-daftar {
            padding: 9px 22px;
            background: var(--theme-primary);
            color: #FFFFFF !important;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 12px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(23, 63, 158, 0.25);
            border: none;
        }

        .btn-nav-daftar:hover {
            background: var(--theme-primary);
            filter: brightness(0.9);
            transform: scale(1.02);
        }

        .sispi-btn-primary {
            background: var(--theme-primary) !important;
            color: #FFFFFF !important;
        }

        .sispi-btn-primary:hover {
            background: var(--theme-primary) !important;
            filter: brightness(0.9);
        }

        .sispi-btn-outline {
            color: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
        }

        .sispi-btn-outline:hover {
            background: var(--theme-primary) !important;
            color: #FFFFFF !important;
        }

        .sispi-badge-blue {
            background: rgba(23, 63, 158, 0.08);
            color: var(--theme-primary) !important;
            border: 1px solid rgba(23, 63, 158, 0.15);
        }

        .cta-navy-gradient-banner {
            background: var(--theme-dark) !important;
        }

        .sispi-footer-navy {
            background: var(--theme-dark) !important;
        }

        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #111827;
            cursor: pointer;
            padding: 4px;
        }

        /* Mobile Slide Down Drawer */
        .mobile-slide-menu {
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            background: #FFFFFF;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-bottom: 1px solid #E2E8F0;
            z-index: 999;
            padding: 24px 32px;
            display: none;
            flex-direction: column;
            gap: 16px;
            transition: all 0.3s ease;
        }

        .mobile-slide-menu.active {
            display: flex;
        }

        /* ----------------------------------------------------
           PAGE 1: BERANDA - Hero Section (~650-720px)
        ---------------------------------------------------- */
        .hero-section-wrapper {
            min-height: 700px;
            background-color: #F7F9FC;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
            background-size: 32px 32px;
            padding-top: 130px;
            padding-bottom: 70px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero-subtle-glow {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(23, 63, 158, 0.08) 0%, rgba(247, 249, 252, 0) 70%);
            pointer-events: none;
        }

        .hero-layout-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 56px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #EAF0FF;
            border: 1px solid rgba(23, 63, 158, 0.2);
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--theme-primary);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        .hero-main-h1 {
            font-size: 3.5rem; /* ~56px */
            font-weight: 800;
            color: #111827;
            line-height: 1.15;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
        }

        .hero-main-h1 span.highlight-text {
            color: var(--theme-primary);
            position: relative;
            display: inline-block;
            z-index: 1;
        }

        .hero-main-h1 span.highlight-text::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--theme-secondary);
            border-radius: 3px;
            z-index: -1;
        }

        .hero-desc-p {
            font-size: 1.1rem;
            color: #64748B;
            line-height: 1.75;
            margin-bottom: 36px;
            max-width: 560px;
        }

        .hero-btn-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .hero-trust-indicators {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748B;
            border-top: 1px solid #E2E8F0;
            padding-top: 24px;
            max-width: 560px;
        }

        /* HERO RIGHT SIDE ANIMATED GLASS CARD */
        .hero-animated-card-container {
            position: relative;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .hero-animated-glass-card {
            background: linear-gradient(145deg, var(--card-grad-start) 0%, var(--card-grad-end) 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 28px;
            padding: 40px 36px;
            box-shadow: 0 20px 48px rgba(23, 63, 158, 0.35);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            animation: {{ ($landingSettings['floating_card_animation'] ?? '1') == '1' ? 'heroCardFloatMotion 5s ease-in-out infinite' : 'none' }};
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
            will-change: transform;
        }

        .hero-animated-glass-card:hover {
            transform: translateY(-12px) scale(1.02) !important;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.45);
        }

        .hero-card-white-icon {
            width: 64px;
            height: 64px;
            background: #FFFFFF;
            border-radius: 20px;
            color: var(--card-icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: transform 0.35s ease;
        }

        .hero-animated-glass-card:hover .hero-card-white-icon {
            transform: scale(1.12) rotate(6deg);
        }

        .hero-animated-glass-card h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }

        .hero-animated-glass-card p {
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.95rem;
            line-height: 1.65;
            margin: 0;
        }

        @keyframes heroCardFloatMotion {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-14px);
            }
        }

        /* DARK NAVY DASHBOARD MOCKUP */
        .dashboard-dark-frame {
            background: #0B1736;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 60px rgba(11, 23, 54, 0.25);
            padding: 28px;
            position: relative;
        }

        .dashboard-dark-header {
            margin-bottom: 20px;
            position: relative;
        }

        .dashboard-dark-sub {
            color: #F4A623;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }

        .dashboard-dark-title {
            color: #FFFFFF;
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
        }

        .dashboard-window-dots {
            display: flex;
            gap: 6px;
            position: absolute;
            top: 4px;
            right: 0;
        }

        .dashboard-window-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dashboard-dark-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .dark-metric-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 16px;
        }

        .dark-metric-val {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .dark-metric-lbl {
            color: #94A3B8;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .dark-progress-wrapper {
            margin-bottom: 20px;
        }

        .dark-chart-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 48px;
            gap: 8px;
            margin-bottom: 16px;
        }

        .dark-chart-bar {
            flex: 1;
            background: rgba(40, 86, 199, 0.4);
            border-radius: 6px 6px 2px 2px;
            transition: height 0.3s ease;
        }

        .dark-chart-bar.active {
            background: #F4A623;
        }

        .dark-activity-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Floating Badges Exact Styling */
        .floating-badge-top {
            position: absolute;
            top: -18px;
            right: -18px;
            background: #FFFFFF;
            border-radius: 14px;
            padding: 10px 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 5;
            border: 1px solid #E2E8F0;
        }

        .floating-badge-mid {
            position: absolute;
            left: -24px;
            top: 48%;
            background: #173F9E;
            color: #FFFFFF;
            border-radius: 12px;
            padding: 8px 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
            z-index: 5;
        }

        .floating-badge-bottom {
            position: absolute;
            bottom: -18px;
            left: -18px;
            background: #FFFFFF;
            border-radius: 14px;
            padding: 10px 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 5;
            border: 1px solid #E2E8F0;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ----------------------------------------------------
           BERANDA — STATISTICS
        ---------------------------------------------------- */
        .section-integrated-wrapper {
            padding: 90px 0;
            background: #FFFFFF;
        }

        .integrated-split-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 56px;
            align-items: center;
        }

        .stats-cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .stat-card-white {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 4px 20px rgba(11, 23, 54, 0.04);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-card-white:hover {
            border-color: rgba(23, 63, 158, 0.3);
            box-shadow: 0 12px 30px rgba(23, 63, 158, 0.1);
            transform: translateY(-4px);
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            background: #EAF0FF;
            color: #173F9E;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            margin-bottom: 6px;
        }

        .stat-card-number {
            font-size: 2.75rem;
            font-weight: 800;
            color: #173F9E;
            line-height: 1;
        }

        .stat-card-label {
            font-size: 0.95rem;
            color: #64748B;
            font-weight: 600;
        }

        /* ----------------------------------------------------
           BERANDA — WHY SISPI (4 Cards)
        ---------------------------------------------------- */
        .section-why-wrapper {
            padding: 90px 0;
            background: #F7F9FC;
        }

        .why-cards-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 52px;
        }

        .why-card-item {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 32px 24px;
            box-shadow: 0 4px 20px rgba(11, 23, 54, 0.04);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }

        .why-card-item:hover {
            transform: translateY(-5px);
            border-color: #173F9E;
            box-shadow: 0 16px 36px rgba(23, 63, 158, 0.12);
        }

        .why-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #EAF0FF;
            color: #173F9E;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 20px;
            transition: all 0.25s ease;
        }

        .why-card-item:hover .why-card-icon {
            background: #173F9E;
            color: #FFFFFF;
            transform: scale(1.08);
        }

        .why-card-item h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        .why-card-item p {
            color: #64748B;
            font-size: 0.9rem;
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .why-arrow-btn {
            margin-top: auto;
            color: #173F9E;
            font-weight: 700;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.25s ease;
        }

        .why-card-item:hover .why-arrow-btn {
            gap: 12px;
        }

        /* ----------------------------------------------------
           BERANDA — WORKFLOW (01 - 06 Stepper)
        ---------------------------------------------------- */
        .section-workflow-wrapper {
            padding: 90px 0;
            background: #FFFFFF;
        }

        .workflow-horizontal-stepper {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-top: 56px;
            position: relative;
        }

        .workflow-step-item {
            background: #F7F9FC;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 16px;
            text-align: center;
            transition: all 0.25s ease;
        }

        .workflow-step-item:hover {
            background: #FFFFFF;
            border-color: #173F9E;
            box-shadow: 0 10px 28px rgba(23, 63, 158, 0.1);
            transform: translateY(-4px);
        }

        .workflow-step-num-circle {
            width: 36px;
            height: 36px;
            background: #173F9E;
            color: #FFFFFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            margin: 0 auto 14px;
        }

        .workflow-step-item h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        /* ----------------------------------------------------
           BERANDA — CTA Section Full Width
        ---------------------------------------------------- */
        .cta-navy-gradient-banner {
            background: var(--cta-bg-color) !important;
            color: #FFFFFF;
            padding: 85px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-navy-gradient-banner h2 {
            font-size: 2.75rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 16px;
        }

        .cta-navy-gradient-banner p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 680px;
            margin: 0 auto 36px;
        }

        .cta-btn-white-solid {
            background: #FFFFFF;
            color: var(--theme-primary) !important;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 32px;
            border-radius: 999px;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .cta-btn-white-solid:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.25);
            background: #F8FAFC;
            color: var(--theme-primary) !important;
        }

        .cta-btn-outline-white {
            background: transparent;
            color: #FFFFFF !important;
            border: 2px solid #FFFFFF;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 32px;
            border-radius: 999px;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
        }

        .cta-btn-outline-white:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.15);
            color: #FFFFFF !important;
        }

        /* ----------------------------------------------------
           PAGE 2 & 3 & 4 Sections
        ---------------------------------------------------- */
        .about-values-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-top: 48px;
        }

        .about-value-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 18px;
            box-shadow: 0 4px 16px rgba(11, 23, 54, 0.04);
            transition: all 0.25s ease;
            text-align: center;
        }

        .about-value-card:hover {
            border-color: #F4A623;
            transform: translateY(-4px);
        }

        .features-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-top: 48px;
        }

        .feature-card-blue-animated {
            background: linear-gradient(145deg, var(--feature-card-start) 0%, var(--feature-card-end) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 16px 36px rgba(23, 63, 158, 0.25);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, border-color 0.4s ease;
            animation: {{ ($landingSettings['features_animation'] ?? '1') == '1' ? 'cardFloatVertical 6s ease-in-out infinite' : 'none' }};
            will-change: transform;
        }

        .feature-card-blue-animated:nth-child(2) {
            animation-delay: 1.8s;
        }

        .feature-card-blue-animated:nth-child(3) {
            animation-delay: 3.6s;
        }

        .feature-card-blue-animated:hover {
            transform: translateY(-12px) scale(1.02) !important;
            box-shadow: 0 24px 50px rgba(23, 63, 158, 0.45);
            border-color: rgba(255, 255, 255, 0.45);
        }

        .feature-icon-white-box {
            width: 58px;
            height: 58px;
            background: #FFFFFF;
            border-radius: 18px;
            color: var(--feature-card-icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.16);
            transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feature-card-blue-animated:hover .feature-icon-white-box {
            transform: scale(1.12) rotate(6deg);
        }

        .feature-card-blue-animated h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }

        .feature-card-blue-animated p {
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.95rem;
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .feature-cta-white-link {
            margin-top: auto;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.25s ease, color 0.25s ease;
        }

        .feature-card-blue-animated:hover .feature-cta-white-link {
            gap: 14px;
            color: #F4A623;
        }

        @keyframes cardFloatVertical {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .feature-card-white-animated {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 12px 32px rgba(11, 23, 54, 0.05);
            color: #111827;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, border-color 0.4s ease;
            animation: cardFloatVertical 6s ease-in-out infinite;
            will-change: transform;
        }

        .feature-card-white-animated:nth-child(4) {
            animation-delay: 1.2s;
        }

        .feature-card-white-animated:nth-child(5) {
            animation-delay: 2.4s;
        }

        .feature-card-white-animated:nth-child(6) {
            animation-delay: 3.6s;
        }

        .feature-card-white-animated:hover {
            transform: translateY(-12px) scale(1.02) !important;
            box-shadow: 0 24px 48px rgba(23, 63, 158, 0.18);
            border-color: #173F9E;
        }

        .feature-icon-blue-box {
            width: 58px;
            height: 58px;
            background: #173F9E;
            border-radius: 18px;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(23, 63, 158, 0.25);
            transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feature-card-white-animated:hover .feature-icon-blue-box {
            transform: scale(1.12) rotate(-6deg);
        }

        .feature-card-white-animated h3 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }

        .feature-card-white-animated p {
            color: #64748B;
            font-size: 0.95rem;
            line-height: 1.65;
            margin-bottom: 0;
        }

        .feature-card-item {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: 0 4px 20px rgba(11, 23, 54, 0.04);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }

        .feature-card-item:hover {
            transform: translateY(-5px);
            border-color: #173F9E;
            box-shadow: 0 16px 36px rgba(23, 63, 158, 0.12);
        }

        .feature-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #EAF0FF;
            color: #173F9E;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 20px;
            transition: all 0.25s ease;
        }

        .feature-card-item:hover .feature-icon-box {
            transform: scale(1.08);
            background: #173F9E;
            color: #FFFFFF;
        }

        .feature-card-item h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        .feature-card-item p {
            color: #64748B;
            font-size: 0.925rem;
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .feature-cta-link {
            margin-top: auto;
            color: #173F9E;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.25s ease;
        }

        .feature-card-item:hover .feature-cta-link {
            gap: 12px;
        }

        .berita-filter-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 36px;
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

        /* ----------------------------------------------------
           FOOTER
        ---------------------------------------------------- */
        footer.sispi-footer-navy {
            background: var(--footer-bg-color) !important;
            color: #94A3B8;
            padding: 80px 0 36px;
        }

        .footer-cols-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 56px;
            padding-bottom: 56px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-cols-grid h4 {
            color: #FFFFFF;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-links-col {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links-col a {
            color: #94A3B8;
            text-decoration: none !important;
            font-size: 0.925rem;
            transition: color 0.2s ease;
        }

        .footer-links-col a:hover {
            color: #60A5FA;
        }

        .footer-copy-text {
            text-align: center;
            padding-top: 36px;
            font-size: 0.9rem;
            color: #64748B;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-layout-grid {
                grid-template-columns: 1fr;
                gap: 48px;
                text-align: center;
            }
            .hero-desc-p {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-btn-row {
                justify-content: center;
            }
            .integrated-split-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .why-cards-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            .workflow-horizontal-stepper {
                grid-template-columns: repeat(3, 1fr);
            }
            .about-values-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .features-grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-cols-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-menu-list, .btn-nav-masuk, .btn-nav-daftar {
                display: none;
            }
            .hamburger-btn {
                display: block;
            }
            .why-cards-grid-4 {
                grid-template-columns: 1fr;
            }
            .workflow-horizontal-stepper {
                grid-template-columns: repeat(2, 1fr);
            }
            .about-values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .features-grid-3 {
                grid-template-columns: 1fr;
            }
            .stats-cards-grid {
                grid-template-columns: 1fr;
            }
            .footer-cols-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Slide Down Drawer -->
    <div class="mobile-slide-menu" id="mobileSlideMenu">
        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('img/LogoPolinema.png') }}" alt="Logo" width="32">
                <span style="font-weight: 800; color: #173F9E;">SISPI POLINEMA</span>
            </div>
            <button id="closeMobileMenu" style="background:none; border:none; font-size:1.4rem; color:#64748B;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="d-flex flex-column gap-3 py-2">
            <a href="#beranda" class="mobile-link text-dark font-weight-bold text-decoration-none">Beranda</a>
            <a href="#tentang" class="mobile-link text-dark font-weight-bold text-decoration-none">Tentang</a>
            <a href="#fitur" class="mobile-link text-dark font-weight-bold text-decoration-none">Fitur</a>
            <a href="#berita-acara" class="mobile-link text-dark font-weight-bold text-decoration-none">Berita Acara</a>
        </div>

        <div class="d-flex flex-column gap-2 pt-2 border-top">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="sispi-btn sispi-btn-primary w-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-masuk text-center">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav-daftar text-center">Daftar</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <!-- GLOBAL STICKY NAVBAR (Height ~72px) -->
    <nav class="sispi-navbar-sticky" id="mainStickyNavbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-brand-group">
                <div class="nav-brand-logo">
                    <img src="{{ asset('img/LogoPolinema.png') }}" alt="Logo SPI Politeknik Negeri Malang">
                </div>
                <div class="nav-brand-text">SISPI</div>
            </a>

            <ul class="nav-menu-list">
                <li><a href="#beranda" class="nav-item-link active">Beranda</a></li>
                <li><a href="#tentang" class="nav-item-link">Tentang</a></li>
                <li><a href="#fitur" class="nav-item-link">Fitur</a></li>
                <li><a href="#berita-acara" class="nav-item-link">Berita Acara</a></li>
            </ul>

            <div class="nav-btn-group">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="sispi-btn sispi-btn-primary" style="padding: 8px 20px;">
                            <i class="fas fa-gauge-high"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav-masuk">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav-daftar">Daftar</a>
                        @endif
                    @endauth
                @endif

                <button class="hamburger-btn" id="openMobileMenu" aria-label="Hamburger Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- PAGE 1: BERANDA - Hero Section (~650-720px) -->
    <section id="beranda" class="hero-section-wrapper">
        <div class="hero-subtle-glow"></div>

        <div class="sispi-container w-100">
            <div class="hero-layout-grid">
                <!-- KIRI: Dot Badge, Headline, Description, Buttons, Micro Trust Row -->
                <div>
                    <div class="hero-badge-tag">
                        <span style="width: 6px; height: 6px; background: var(--theme-primary); border-radius: 50%; display: inline-block;"></span>
                        {{ $landingSettings['hero_badge_text'] ?? 'SISTEM INFORMASI SPI' }}
                    </div>

                    <h1 class="hero-main-h1">
                        @php
                            $fullTitle = $landingSettings['hero_title'] ?? 'Sistem Informasi Supervisi dan Pengawasan Internal';
                            $hlText   = $landingSettings['hero_highlight_text'] ?? 'Pengawasan Internal';
                            if ($hlText && str_contains($fullTitle, $hlText)) {
                                [$before, $after] = explode($hlText, $fullTitle, 2);
                                echo e($before) . '<span class="highlight-text">' . e($hlText) . '</span>' . e($after);
                            } else {
                                echo e($fullTitle);
                            }
                        @endphp
                    </h1>

                    <p class="hero-desc-p">
                        {{ $landingSettings['hero_description'] ?? 'Solusi digital terpadu untuk manajemen audit internal, penilaian resiko, dan monitoring tindak lanjut yang efektif dan efesien.' }}
                    </p>

                    <div class="hero-btn-row">
                        <a href="{{ url($landingSettings['hero_btn_primary_url'] ?? '/login') }}" class="sispi-btn sispi-btn-primary">
                            <span>{{ $landingSettings['hero_btn_primary_text'] ?? 'Mulai Sekarang →' }}</span>
                        </a>
                        <a href="{{ $landingSettings['hero_btn_secondary_url'] ?? '#tentang' }}" class="sispi-btn sispi-btn-outline">
                            {{ $landingSettings['hero_btn_secondary_text'] ?? 'Pelajari Lebih Lanjut' }}
                        </a>
                    </div>

                    <div class="hero-trust-indicators">
                        <span><i class="fas fa-landmark mr-1" style="color: #64748B;"></i> Institusi Resmi</span>
                        <span><i class="fas fa-lock mr-1" style="color: #64748B;"></i> Keamanan Data</span>
                        <span><i class="fas fa-square-check mr-1" style="color: #10B981;"></i> Terverifikasi</span>
                    </div>
                </div>

                <!-- KANAN: Card atau Gambar sesuai pengaturan Super Admin -->
                <div>
                    @php $heroMode = $landingSettings['hero_display_mode'] ?? 'card'; @endphp

                    @if($heroMode === 'image' && !empty($landingSettings['hero_image']))
                        {{-- MODE GAMBAR --}}
                        <div style="display:flex;align-items:center;justify-content:center;">
                            <img src="{{ asset('landing_images/' . $landingSettings['hero_image']) }}"
                                 alt="{{ $landingSettings['hero_image_alt'] ?? 'Ilustrasi SISPI' }}"
                                 style="width:100%;max-width:520px;border-radius:24px;object-fit:cover;box-shadow:0 24px 60px rgba(23,63,158,0.18);animation:{{ ($landingSettings['floating_card_animation'] ?? '1') == '1' ? 'heroCardFloatMotion 5s ease-in-out infinite' : 'none' }};">
                        </div>
                    @else
                        {{-- MODE KARTU (default) --}}
                        <div class="hero-animated-card-container">
                            <div class="hero-animated-glass-card">
                                <div class="hero-card-white-icon">
                                    <i class="{{ $landingSettings['floating_card_icon'] ?? 'fas fa-clipboard-check' }}"></i>
                                </div>
                                <h3>{{ $landingSettings['floating_card_title'] ?? 'Audit Management' }}</h3>
                                <p>{{ $landingSettings['floating_card_desc'] ?? 'Kelola seluruh proses audit internal dengan sistematis, dari perencanaan hingga pelaporan hasil audit.' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <!-- PAGE 2: TENTANG KAMI SECTION -->
    <section id="tentang" style="padding: 90px 0; background: #FFFFFF; border-top: 1px solid #E2E8F0; position: relative;">
        <div class="sispi-container">
            <!-- Centered Header -->
            <div class="text-center mx-auto" style="max-width: 760px; margin: 0 auto 56px; text-align: center;">
                <div class="d-flex justify-content-center mb-3">
                    <span class="sispi-badge sispi-badge-blue">{{ $landingSettings['about_badge'] ?? 'TENTANG KAMI' }}</span>
                </div>
                <h2 style="font-size: 2.75rem; font-weight: 800; margin-bottom: 16px; text-align: center;">
                    {{ $landingSettings['about_title'] ?? 'Transformasi Digital untuk Audit Internal' }}
                </h2>
                <p style="color: #64748B; font-size: 1.1rem; line-height: 1.7; margin: 0 auto; text-align: center; max-width: 680px;">
                    {{ $landingSettings['about_description'] ?? 'SISPI hadir sebagai solusi komprehensif untuk meningkatkan efektivitas pengawasan internal organisasi Anda melalui digitalisasi proses audit.' }}
                </p>
            </div>

            <div class="hero-layout-grid align-items-center mb-5">
                <!-- KIRI: Detail Deskripsi & Checklist Items -->
                <div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin-bottom: 16px;">
                        {{ $landingSettings['about_why_title'] ?? 'Mengapa Memilih SISPI?' }}
                    </h3>

                    <p style="color: #64748B; font-size: 1rem; line-height: 1.7; margin-bottom: 16px;">
                        {{ $landingSettings['about_why_p1'] ?? 'Sispi dirancang khusus untuk memenuhi kebutuhan audit internal yang modern dan efisien. Dengan fitur-fitur lengkap dan interface yang user-friendly, kami membantu tim audit Anda bekerja lebih produktif.' }}
                    </p>

                    <p style="color: #64748B; font-size: 1rem; line-height: 1.7; margin-bottom: 24px;">
                        {{ $landingSettings['about_why_p2'] ?? 'Sistem kami mengintegrasikan seluruh proses pengawasan internal, mulai dari penyusunan peta resiko, pelaksanaan audit, hingga monitoring tindak lanjut rekomendasi.' }}
                    </p>

                    @php
                        $aboutChecklists = [];
                        if (!empty($landingSettings['about_checklists'])) {
                            $aboutChecklists = json_decode($landingSettings['about_checklists'], true);
                        }
                        if (!is_array($aboutChecklists) || empty($aboutChecklists)) {
                            $aboutChecklists = array_filter([
                                $landingSettings['about_checklist_1'] ?? 'Manajemen audit terintegrasi dan terstruktur',
                                $landingSettings['about_checklist_2'] ?? 'Peta risiko yang komprehensif dan real-time',
                                $landingSettings['about_checklist_3'] ?? 'Sistem kolaborasi tim yang efektif',
                                $landingSettings['about_checklist_4'] ?? 'Keamanan data tingkat enterprise',
                            ]);
                        }
                    @endphp
                    <!-- Checklist Items (Dynamic Add/Remove) -->
                    <div class="d-flex flex-column gap-3 mb-4">
                        @foreach($aboutChecklists as $chkItem)
                            @if(trim($chkItem) !== '')
                            <div class="d-flex align-items-center gap-3" style="font-weight: 700; color: #111827; font-size: 1.15rem; margin-bottom: 12px;">
                                <i class="fas fa-check" style="color: var(--theme-primary); font-size: 1.25rem;"></i>
                                <span>{{ $chkItem }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- KANAN: STATISTIK PENGAWASAN (ROYAL BLUE GRADIENT & GLASSMORPHISM) -->
                <div>
                    <div style="background: linear-gradient(145deg, var(--card-grad-start) 0%, var(--card-grad-end) 100%); border-radius: 24px; padding: 36px 32px; box-shadow: 0 20px 50px rgba(23, 63, 158, 0.35); border: 1px solid rgba(255, 255, 255, 0.25);">
                        <!-- Header Tag inside Card -->
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.2) !important;">
                            <div>
                                <span style="color: var(--theme-secondary); font-size: 0.75rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase;">STATISTIK PENGAWASAN</span>
                                <h4 style="color: #FFFFFF; font-size: 1.2rem; font-weight: 800; margin: 0;">Portal SPI Polinema</h4>
                            </div>
                            <div style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>

                        <!-- 2x2 Glassmorphism Metric Grid -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                            <div style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 18px; padding: 20px;">
                                <div style="width: 38px; height: 38px; background: #FFFFFF; border-radius: 12px; color: var(--theme-primary); display: flex; align-items: center; justify-content: center; font-size: 1.05rem; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div style="color: #FFFFFF; font-size: 2.1rem; font-weight: 800; line-height: 1; margin-bottom: 6px;">{{ $welcomeStats[0]['display'] ?? '24' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.85); font-size: 0.875rem; font-weight: 600;">Total Audit</div>
                            </div>

                            <div style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 18px; padding: 20px;">
                                <div style="width: 38px; height: 38px; background: #FFFFFF; border-radius: 12px; color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <i class="fas fa-circle-check"></i>
                                </div>
                                <div style="color: #FFFFFF; font-size: 2.1rem; font-weight: 800; line-height: 1; margin-bottom: 6px;">{{ $welcomeStats[1]['display'] ?? '18' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.85); font-size: 0.875rem; font-weight: 600;">Audit Selesai</div>
                            </div>

                            <div style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 18px; padding: 20px;">
                                <div style="width: 38px; height: 38px; background: #FFFFFF; border-radius: 12px; color: var(--theme-primary); display: flex; align-items: center; justify-content: center; font-size: 1.05rem; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <i class="fas fa-building-columns"></i>
                                </div>
                                <div style="color: #FFFFFF; font-size: 2.1rem; font-weight: 800; line-height: 1; margin-bottom: 6px;">{{ $welcomeStats[2]['display'] ?? '93' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.85); font-size: 0.875rem; font-weight: 600;">Unit Kerja</div>
                            </div>

                            <div style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 18px; padding: 20px;">
                                <div style="width: 38px; height: 38px; background: #FFFFFF; border-radius: 12px; color: var(--theme-primary); display: flex; align-items: center; justify-content: center; font-size: 1.05rem; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <i class="fas fa-file-signature"></i>
                                </div>
                                <div style="color: #FFFFFF; font-size: 2.1rem; font-weight: 800; line-height: 1; margin-bottom: 6px;">{{ $welcomeStats[3]['display'] ?? '6' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.85); font-size: 0.875rem; font-weight: 600;">Berita Acara</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prinsip Pengawasan Internal (5 Cards) -->
            <div style="margin-top: 60px;">
                <h3 class="text-center font-weight-bold mb-4" style="font-size: 2rem;">{{ $landingSettings['about_principles_title'] ?? 'Prinsip Pengawasan Internal' }}</h3>
                <div class="about-values-grid">
                    <div class="about-value-card">
                        <i class="fas fa-shield mb-2" style="font-size: 1.5rem; color: var(--theme-primary);"></i>
                        <h4 style="font-size:1.05rem; font-weight:700;">{{ $landingSettings['about_principle_1'] ?? 'Integritas' }}</h4>
                    </div>

                    <div class="about-value-card">
                        <i class="fas fa-eye mb-2" style="font-size: 1.5rem; color: var(--theme-primary);"></i>
                        <h4 style="font-size:1.05rem; font-weight:700;">{{ $landingSettings['about_principle_2'] ?? 'Transparansi' }}</h4>
                    </div>

                    <div class="about-value-card">
                        <i class="fas fa-scale-balanced mb-2" style="font-size: 1.5rem; color: var(--theme-primary);"></i>
                        <h4 style="font-size:1.05rem; font-weight:700;">{{ $landingSettings['about_principle_3'] ?? 'Akuntabilitas' }}</h4>
                    </div>

                    <div class="about-value-card">
                        <i class="fas fa-user-tie mb-2" style="font-size: 1.5rem; color: var(--theme-primary);"></i>
                        <h4 style="font-size:1.05rem; font-weight:700;">{{ $landingSettings['about_principle_4'] ?? 'Profesionalisme' }}</h4>
                    </div>

                    <div class="about-value-card">
                        <i class="fas fa-bolt mb-2" style="font-size: 1.5rem; color: var(--theme-primary);"></i>
                        <h4 style="font-size:1.05rem; font-weight:700;">{{ $landingSettings['about_principle_5'] ?? 'Efektivitas' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    <!-- PAGE 3: FITUR SECTION -->
    <section id="fitur" style="padding: 90px 0; background: linear-gradient(180deg, #FFFFFF 0%, #F7F9FC 100%);">
        <div class="sispi-container">
            <div class="text-center mx-auto" style="max-width: 760px; margin: 0 auto 56px; text-align: center;">
                <div class="d-flex justify-content-center mb-3">
                    <span class="sispi-badge sispi-badge-blue">{{ $landingSettings['features_badge'] ?? 'FITUR UNGGULAN' }}</span>
                </div>
                <h2>{{ $landingSettings['features_title'] ?? 'Fitur Lengkap untuk Audit yang Efektif' }}</h2>
                <p style="color: #64748B; font-size: 1.05rem; margin-top: 12px;">
                    {{ $landingSettings['features_description'] ?? 'Berbagai fitur canggih yang dirancang untuk mendukung setiap tahapan proses audit internal Anda.' }}
                </p>
            </div>

            <div class="features-grid-3">
                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-clipboard-check"></i></div>
                    <h3>{{ $landingSettings['feature_1_title'] ?? 'Manajemen Audit' }}</h3>
                    <p>{{ $landingSettings['feature_1_desc'] ?? 'Kelola kegiatan audit internal dengan sistematis, termasuk perencanaan, pelaksanaan, dan pelaporan hasil audit secara digital.' }}</p>
                </div>

                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-chart-pie"></i></div>
                    <h3>{{ $landingSettings['feature_2_title'] ?? 'Peta Risiko' }}</h3>
                    <p>{{ $landingSettings['feature_2_desc'] ?? 'Identifikasi dan analisis risiko organisasi dengan visualisasi matriks risiko yang mudah dipahami dan dikelola.' }}</p>
                </div>

                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-file-signature"></i></div>
                    <h3>{{ $landingSettings['feature_3_title'] ?? 'Laporan & Dokumentasi' }}</h3>
                    <p>{{ $landingSettings['feature_3_desc'] ?? 'Buat laporan audit yang profesional dan kelola seluruh dokumentasi dengan sistem penyimpanan digital yang aman.' }}</p>
                </div>

                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-users-gear"></i></div>
                    <h3>{{ $landingSettings['feature_4_title'] ?? 'Kolaborasi Tim' }}</h3>
                    <p>{{ $landingSettings['feature_4_desc'] ?? 'Koordinasi antar tim audit dengan sistem approval, komentar, dan notifikasi yang terintegrasi untuk workflow yang efisien.' }}</p>
                </div>

                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-clipboard-list"></i></div>
                    <h3>{{ $landingSettings['feature_5_title'] ?? 'Monitoring Tindak Lanjut' }}</h3>
                    <p>{{ $landingSettings['feature_5_desc'] ?? 'Pantau dan evaluasi implementasi rekomendasi audit dengan sistem tracking yang efektif dan real-time monitoring.' }}</p>
                </div>

                <div class="feature-card-blue-animated">
                    <div class="feature-icon-white-box"><i class="fas fa-lock"></i></div>
                    <h3>{{ $landingSettings['feature_6_title'] ?? 'Keamanan Data' }}</h3>
                    <p>{{ $landingSettings['feature_6_desc'] ?? 'Proteksi data dengan sistem keamanan berlapis, verifikasi email, dan kontrol akses berbasis role yang ketat.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PAGE 4: BERITA ACARA SECTION -->
    <section id="berita-acara" style="padding: 90px 0; background: #F7F9FC;">
        <div class="sispi-container">
            <div class="text-center" style="max-width: 720px; margin: 0 auto 40px;">
                <span class="sispi-badge sispi-badge-blue mb-3">{{ $landingSettings['berita_badge'] ?? 'Berita Acara' }}</span>
                <h2>{{ $landingSettings['berita_title'] ?? 'Ringkasan Kegiatan Terbaru' }}</h2>
                <p style="color: #64748B; font-size: 1.05rem; margin-top: 12px;">
                    {{ $landingSettings['berita_description'] ?? 'Pantau berita acara terbaru lengkap dengan dokumentasi rapat dan bukti visual.' }}
                </p>
            </div>

            @if (isset($beritaAcaras) && $beritaAcaras->isNotEmpty())
                <div class="row">
                    @foreach ($beritaAcaras as $minute)
                        <div class="col-md-6 col-lg-4 mb-4">
                            @include('components.minute-card', ['minute' => $minute])
                        </div>
                    @endforeach
                </div>

                @if (!empty($moreMinutesExist))
                    <div class="text-center mt-4">
                        <a href="{{ route('welcome.berita-acara') }}" class="sispi-btn sispi-btn-primary">
                            <span>{{ $landingSettings['berita_btn_text'] ?? 'Lihat Semua Berita Acara' }}</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open text-4xl mb-3" style="color: #94A3B8;"></i>
                    <p>Belum ada berita acara publik yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- BERANDA — CTA SECTION FULL WIDTH -->
    <section class="cta-navy-gradient-banner">
        <div class="sispi-container" style="position:relative; z-index:2;">
            <h2>{{ $landingSettings['cta_title'] ?? 'Siap Meningkatkan Efektivitas Audit Internal Anda?' }}</h2>
            <p>{{ $landingSettings['cta_description'] ?? 'Bergabunglah dengan organisasi-organisasi yang telah mempercayai SISPI untuk transformasi digital audit internal mereka.' }}</p>
            <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap mt-4" style="gap: 16px;">
                <a href="{{ route('login') }}" class="cta-btn-white-solid">
                    <span>{{ $landingSettings['cta_btn_text'] ?? 'Mulai Sekarang' }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="cta-btn-outline-white">
                        <span>Daftar Gratis</span>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="sispi-footer-navy">
        <div class="sispi-container">
            <div class="footer-cols-grid">
                <div>
                    <h3 style="color:#ffffff; font-weight:800; margin-bottom:16px;">SISPI</h3>
                    <p style="font-size:0.925rem; line-height:1.7;">{{ $landingSettings['footer_about'] ?? 'Sistem Informasi Supervisi dan Pengawasan Internal yang dirancang untuk meningkatkan efektivitas audit internal organisasi Anda.' }}</p>
                </div>

                <div>
                    <h4>NAVIGASI</h4>
                    <ul class="footer-links-col">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#berita-acara">Berita Acara</a></li>
                    </ul>
                </div>

                <div>
                    <h4>AKSES</h4>
                    <ul class="footer-links-col">
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4>BANTUAN</h4>
                    <ul class="footer-links-col">
                        <li><a href="{{ url('/feedback') }}">Feedback</a></li>
                        <li><a href="{{ url('/feedback') }}">Bantuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-copy-text">
                &copy; {{ date('Y') }} {{ $landingSettings['footer_copyright'] ?? 'SISPI. Sistem Informasi Supervisi dan Pengawasan Internal. All rights reserved.' }}
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    @include('components.minute-card-script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar Sticky Shadow
            const navbar = document.getElementById('mainStickyNavbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Mobile Menu Slide Down Drawer
            const openBtn = document.getElementById('openMobileMenu');
            const closeBtn = document.getElementById('closeMobileMenu');
            const mobileMenu = document.getElementById('mobileSlideMenu');

            if (openBtn && mobileMenu) {
                openBtn.addEventListener('click', function() {
                    mobileMenu.classList.add('active');
                });
            }
            if (closeBtn && mobileMenu) {
                closeBtn.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                });
            }

            // Smooth Scroll Active Link Indicator
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-item-link');

            window.addEventListener('scroll', function() {
                let current = '';
                sections.forEach(section => {
                    const top = section.offsetTop - 100;
                    if (window.scrollY >= top) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>

    <!-- Bootstrap & Dependency Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    {{-- Tombol Edit Web Profil (hanya untuk Super Admin yang sudah login) --}}
    @auth
        @if(auth()->user()->id_level == 1)
        <a href="{{ route('admin.landing-settings.index') }}"
           title="Edit Web Profil"
           style="position:fixed;bottom:24px;right:24px;z-index:9999;display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#173F9E;color:#fff;font-weight:700;font-size:0.82rem;border-radius:999px;text-decoration:none;box-shadow:0 8px 24px rgba(23,63,158,0.4);border:2px solid rgba(255,255,255,0.2);transition:all 0.2s ease;"
           onmouseover="this.style.background='#123382';this.style.transform='translateY(-2px)';"
           onmouseout="this.style.background='#173F9E';this.style.transform='none';">
            <i class="fas fa-pen-to-square"></i>
            Edit Web Profil
        </a>
        @endif
    @endauth

</body>

</html>
