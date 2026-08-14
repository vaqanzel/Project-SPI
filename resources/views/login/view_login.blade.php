@extends('layout.auth')

@section('title', 'Login')

@php
    $loginThemePrimary = \App\Models\LandingPageSetting::getSettings()['theme_primary_color'] ?? '#173F9E';
@endphp

@push('style')
    <style>
        :root {
            --auth-primary: {{ $loginThemePrimary }};
        }

        .auth-form-header {
            margin-bottom: 28px;
        }

        .auth-form-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .auth-form-header p {
            color: #64748B;
            font-size: 0.925rem;
            margin: 0;
        }

        .input-group-custom {
            margin-bottom: 20px;
        }

        .input-group-custom label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #111827;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-wrapper .form-control {
            height: 50px;
            padding-left: 48px;
            padding-right: 48px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            font-size: 0.95rem;
            color: #111827;
            background-color: #F7F9FC;
            transition: all 0.2s ease;
        }

        .input-wrapper .form-control:focus {
            background-color: #FFFFFF;
            border-color: var(--auth-primary);
            box-shadow: 0 0 0 4px rgba(23, 63, 158, 0.1);
            outline: none;
        }

        .toggle-password-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .toggle-password-btn:hover {
            color: var(--auth-primary);
        }

        .btn-login-action {
            height: 52px;
            width: 100%;
            background: var(--auth-primary) !important;
            border: none;
            border-radius: 12px;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 8px 24px rgba(23, 63, 158, 0.25);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-login-action:hover {
            background: var(--auth-primary) !important;
            filter: brightness(0.9);
            transform: scale(1.01);
            box-shadow: 0 12px 28px rgba(23, 63, 158, 0.35);
        }

        .alert-error-box {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 0.9rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
    </style>
@endpush

@section('main')
    <div class="auth-form-header">
        <h2>Login</h2>
        <p>Masuk menggunakan akun SISPI Anda.</p>
    </div>

    @if ($errors->any())
        <div class="alert-error-box">
            <i class="fas fa-circle-exclamation text-lg"></i>
            <div>
                <strong>Login Gagal:</strong> {{ $errors->first() }}
            </div>
        </div>
    @endif

    <form action="{{ url('login/proses') }}" method="post" id="loginForm">
        @csrf

        <div class="input-group-custom">
            <label for="username">Username</label>
            <div class="input-wrapper">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                    name="username" value="{{ old('username') }}" placeholder="Masukkan Username Anda" tabindex="1" required
                    autofocus>
                <i class="fas fa-user input-icon"></i>
            </div>
        </div>

        <div class="input-group-custom mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="mb-0">Password</label>
                <a href="javascript:void(0);" onclick="alert('Silakan hubungi Administrator SPI Polinema untuk reset password.');" style="color: var(--auth-primary); font-weight: 600; font-size: 0.85rem; text-decoration: none;">
                    Forgot Password?
                </a>
            </div>
            <div class="input-wrapper">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Masukkan Password Anda" tabindex="2" required>
                <i class="fas fa-lock input-icon"></i>
                <button type="button" class="toggle-password-btn" id="togglePasswordBtn" title="Show/Hide Password">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
        </div>

        <div class="mb-4 pt-2">
            <button type="submit" class="btn-login-action" tabindex="3" id="btnLogin">
                <span>Masuk</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div class="text-center pt-3 border-top">
            <span style="color: #64748B; font-size: 0.9rem;">Belum memiliki akun?</span>
            <a href="{{ route('register') }}" style="color: var(--auth-primary); font-weight: 700; font-size: 0.9rem; text-decoration: none; margin-left: 4px;">
                Daftar
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (toggleBtn && passwordInput && toggleIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }

            const loginForm = document.getElementById('loginForm');
            const btnLogin = document.getElementById('btnLogin');
            if (loginForm && btnLogin) {
                loginForm.addEventListener('submit', function() {
                    btnLogin.disabled = true;
                    btnLogin.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
                });
            }
        });
    </script>
@endpush
