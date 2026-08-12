<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') - SISPI Politeknik Negeri Malang</title>

    <!-- Google Font Inter & FontAwesome 6 -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS & Theme -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sispi-theme.css') }}">

    @stack('style')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #F7F9FC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .auth-split-wrapper {
            width: 100%;
            min-height: 100vh;
            display: flex;
        }

        /* KIRI & KANAN 50% Desktop Split */
        .auth-panel-visual {
            flex: 1;
            background: linear-gradient(135deg, #173F9E 0%, #0B1736 100%);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .auth-panel-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.08;
            background-image: radial-gradient(circle at 50% 50%, #FFFFFF 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .auth-brand-row {
            display: flex;
            align-items: center;
            gap: 16px;
            z-index: 2;
        }

        .auth-brand-logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-brand-logo-box img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .auth-visual-body {
            z-index: 2;
            margin: auto 0;
            max-width: 520px;
        }

        .auth-visual-body h1 {
            font-size: 2.75rem;
            font-weight: 800;
            color: #FFFFFF;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .auth-visual-body h1 span {
            color: #F4A623;
        }

        .auth-visual-body p {
            font-size: 1.05rem;
            color: #CBD5E1;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        /* GSAP Orbit Animation Layout matching reference design */
        .auth-gsap-orbit-container {
            position: relative;
            width: 100%;
            height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 10px;
        }

        .orbit-bg-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1.2px, transparent 1.2px);
            background-size: 24px 24px;
            opacity: 0.35;
        }

        .orbit-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px dashed rgba(255, 255, 255, 0.22);
        }

        .orbit-ring-outer {
            width: 290px;
            height: 290px;
        }

        .orbit-ring-inner {
            width: 210px;
            height: 210px;
        }

        .orbit-dot-node {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #60A5FA;
            box-shadow: 0 0 10px #60A5FA;
        }

        .orbit-dot-node-1 { top: 0; left: 50%; transform: translate(-50%, -50%); }
        .orbit-dot-node-2 { bottom: 18%; right: 8%; background: #F4A623; box-shadow: 0 0 10px #F4A623; }
        .orbit-dot-node-3 { top: 35%; left: 0; transform: translate(-50%, -50%); background: #34D399; box-shadow: 0 0 10px #34D399; }

        .orbit-center-shield {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .shield-custom-shape {
            width: 110px;
            height: 132px;
            background: linear-gradient(180deg, #2563EB 0%, #1D4ED8 50%, #1E3A8A 100%);
            clip-path: polygon(50% 0%, 100% 18%, 100% 72%, 50% 100%, 0% 72%, 0% 18%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 40px rgba(29, 78, 216, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.35);
        }

        .shield-inner-circle {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10B981;
            font-size: 1.35rem;
            margin-bottom: 8px;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .shield-brand-text {
            font-weight: 900;
            font-size: 1rem;
            color: #FFFFFF;
            letter-spacing: 0.12em;
        }

        .orbit-top-doc-card {
            position: absolute;
            top: 15px;
            z-index: 15;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 18px;
            padding: 14px 20px;
            width: 220px;
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.35);
        }

        .doc-yellow-dot {
            width: 7px;
            height: 7px;
            background: #F59E0B;
            border-radius: 50%;
            display: inline-block;
        }

        .doc-header-title {
            font-size: 0.75rem;
            font-weight: 800;
            color: #CBD5E1;
            letter-spacing: 0.06em;
        }

        .doc-verified-chip {
            background: rgba(16, 185, 129, 0.22);
            color: #34D399;
            border: 1px solid rgba(52, 211, 153, 0.4);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 3px 9px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .doc-skeleton-line {
            height: 5px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
            margin-top: 6px;
        }

        .auth-panel-form {
            flex: 1;
            background: #F7F9FC;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            overflow-y: auto;
            position: relative;
        }

        .auth-form-card-container {
            width: 100%;
            max-width: 520px;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(11, 23, 54, 0.06);
            border: 1px solid #E2E8F0;
        }

        .auth-back-btn {
            position: absolute;
            top: 40px;
            right: 40px;
            color: #64748B;
            text-decoration: none !important;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .auth-back-btn:hover {
            color: #173F9E;
        }

        @media (max-width: 992px) {
            .auth-split-wrapper {
                flex-direction: column;
            }
            .auth-panel-visual {
                display: none;
            }
            .auth-panel-form {
                padding: 40px 20px;
                min-height: 100vh;
            }
            .auth-form-card-container {
                padding: 28px 24px;
            }
            .auth-back-btn {
                top: 20px;
                right: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-split-wrapper">
        <!-- KIRI 50%: Visual Panel -->
        <div class="auth-panel-visual">
            <div class="auth-brand-row">
                <div class="auth-brand-logo-box">
                    <img src="{{ asset('img/LogoPolinema.png') }}" alt="Logo Polinema">
                </div>
                <div>
                    <div style="font-weight: 800; font-size: 1.2rem; color: #ffffff;">SISPI POLINEMA</div>
                    <div style="font-size: 0.8rem; color: #94A3B8; font-weight: 600;">Satuan Informasi Supervisi dan Pengawasan Internal</div>
                </div>
            </div>

            <div class="auth-visual-body">
                <h1>Selamat <span>Datang</span></h1>
                <p>Masuk ke SISPI untuk mengelola dan memantau proses pengawasan internal Politeknik Negeri Malang.</p>

                <!-- GSAP Animated Audit Orbit Graphic (Matching Reference Image 1) -->
                <div class="auth-gsap-orbit-container">
                    <div class="orbit-bg-grid"></div>

                    <!-- Outer Dashed Orbit Ring -->
                    <div class="orbit-ring orbit-ring-outer">
                        <div class="orbit-dot-node orbit-dot-node-1"></div>
                        <div class="orbit-dot-node orbit-dot-node-2"></div>
                    </div>

                    <!-- Inner Dashed Orbit Ring -->
                    <div class="orbit-ring orbit-ring-inner">
                        <div class="orbit-dot-node orbit-dot-node-3"></div>
                    </div>

                    <!-- Top Floating Laporan Audit Card -->
                    <div class="orbit-top-doc-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="doc-yellow-dot"></span>
                                <span class="doc-header-title">LAPORAN AUDIT</span>
                            </div>
                            <span class="doc-verified-chip">
                                <i class="fas fa-check"></i> VERIFIED
                            </span>
                        </div>
                        <div class="doc-skeleton-line" style="width: 85%;"></div>
                        <div class="doc-skeleton-line" style="width: 55%;"></div>
                    </div>

                    <!-- Center Shield Emblem with SPI Text -->
                    <div class="orbit-center-shield">
                        <div class="shield-custom-shape">
                            <div class="shield-inner-circle">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="shield-brand-text">SISPI</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="font-size:0.85rem; color:#94A3B8; border-top: 1px solid rgba(255,255,255,0.1); padding-top:20px;">
                &copy; {{ date('Y') }}  SISPI. Sistem Informasi Supervisi dan Pengawasan Internal. All rights reserved.
            </div>
        </div>

        <!-- KANAN 50%: Form Panel -->
        <div class="auth-panel-form">
            <a href="{{ url('/') }}" class="auth-back-btn">
                <i class="fas fa-arrow-left"></i> Beranda
            </a>

            <div class="auth-form-card-container">
                @yield('main')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof gsap !== 'undefined') {
                // Continuous 360-degree rotation for outer orbit ring
                gsap.to(".orbit-ring-outer", {
                    rotation: 360,
                    duration: 28,
                    repeat: -1,
                    ease: "none"
                });

                // Continuous reverse rotation for inner orbit ring
                gsap.to(".orbit-ring-inner", {
                    rotation: -360,
                    duration: 20,
                    repeat: -1,
                    ease: "none"
                });

                // Floating up-down motion for top document card
                gsap.to(".orbit-top-doc-card", {
                    y: -10,
                    duration: 2.8,
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut"
                });

                // Subtle floating motion for central shield emblem
                gsap.to(".orbit-center-shield", {
                    y: -6,
                    duration: 3.2,
                    repeat: -1,
                    yoyo: true,
                    ease: "power1.inOut"
                });

                // Pulse glow animation for inner green check circle
                gsap.to(".shield-inner-circle", {
                    scale: 1.1,
                    boxShadow: "0 0 25px rgba(16, 185, 129, 0.6)",
                    duration: 1.6,
                    repeat: -1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
