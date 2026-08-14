@extends('layout.auth')

@section('title', 'Register')

@php
    $registerThemePrimary = \App\Models\LandingPageSetting::getSettings()['theme_primary_color'] ?? '#173F9E';
@endphp

@push('style')
    <style>
        :root {
            --auth-primary: {{ $registerThemePrimary }};
        }

        .auth-form-header {
            margin-bottom: 24px;
        }

        .auth-form-header h2 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .auth-form-header p {
            color: #64748B;
            font-size: 0.9rem;
            margin: 0;
        }

        .input-group-custom {
            margin-bottom: 16px;
        }

        .input-group-custom label {
            font-weight: 600;
            font-size: 0.825rem;
            color: #111827;
            margin-bottom: 6px;
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
            font-size: 0.95rem;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper .form-control,
        .input-wrapper select.form-control {
            height: 46px;
            padding-left: 44px;
            padding-right: 16px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            font-size: 0.9rem;
            color: #111827;
            background-color: #F7F9FC;
            transition: all 0.2s ease;
            width: 100%;
        }

        .input-wrapper .form-control:focus,
        .input-wrapper select.form-control:focus {
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
            font-size: 0.95rem;
            z-index: 3;
        }

        .btn-register-action {
            height: 48px;
            padding: 0 28px;
            background: var(--auth-primary) !important;
            border: none;
            border-radius: 12px;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 8px 24px rgba(23, 63, 158, 0.25);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-register-action:hover {
            background: var(--auth-primary) !important;
            filter: brightness(0.9);
            transform: scale(1.01);
        }

        .btn-register-reset {
            height: 48px;
            padding: 0 20px;
            background: #F1F5F9;
            border: 1px solid #CBD5E1;
            border-radius: 12px;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-register-reset:hover {
            background: #E2E8F0;
            color: #111827;
        }

        .error-feedback {
            color: #DC2626;
            font-size: 0.8rem;
            margin-top: 4px;
        }

        .strength-bar-track {
            height: 4px;
            background: #E2E8F0;
            border-radius: 4px;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
    </style>
@endpush

@section('main')
    <div class="auth-form-header">
        <h2>Buat Akun SISPI</h2>
        <p>Daftarkan akun untuk mengakses sistem pengawasan internal.</p>
    </div>

    <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" id="registerForm">
        @csrf

        <div class="row">
            <!-- Nama & Username -->
            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="name">NAMA</label>
                    <div class="input-wrapper">
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="Masukkan Nama..." required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('name')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="username">USERNAME</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" placeholder="Masukkan Username..." required>
                        <i class="fas fa-at input-icon"></i>
                    </div>
                    @error('username')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email & NIP -->
            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="email">EMAIL</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Masukkan Email..." required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="nip">NIP</label>
                    <div class="input-wrapper">
                        <input type="text" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip"
                            value="{{ old('nip') }}" placeholder="Masukkan NIP..." required>
                        <i class="fas fa-hashtag input-icon"></i>
                    </div>
                    @error('nip')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Password & Konfirmasi Password -->
            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="password">PASSWORD</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Masukkan Password..." required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-password-btn" id="toggleRegPassBtn" title="Show/Hide Password">
                            <i class="fas fa-eye" id="toggleRegPassIcon"></i>
                        </button>
                    </div>
                    <div class="strength-bar-track">
                        <div class="strength-bar-fill" id="strengthFill"></div>
                    </div>
                    <div id="strengthLabel" style="font-size:0.75rem; color:#64748B; margin-top:4px; font-weight:600;"></div>
                    @error('password')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="confirmation">KONFIRMASI PASSWORD</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="confirmation" name="confirmation"
                            placeholder="Konfirmasi Password..." required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                    <div id="matchLabel" style="font-size:0.75rem; margin-top:4px; font-weight:600;"></div>
                </div>
            </div>

            <!-- Unit Kerja & Jabatan -->
            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="unit_kerja">UNIT KERJA</label>
                    <div class="input-wrapper">
                        <select id="unit_kerja" name="id_unit_kerja" class="form-control @error('id_unit_kerja') is-invalid @enderror" required>
                            <option value="">- Pilih Unit Kerja -</option>
                            @foreach ($unit_kerjas as $unit_kerja)
                                <option value="{{ $unit_kerja->id }}" {{ old('id_unit_kerja') == $unit_kerja->id ? 'selected' : '' }}>
                                    {{ $unit_kerja->nama_unit_kerja }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-sitemap input-icon"></i>
                    </div>
                    @error('id_unit_kerja')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group-custom">
                    <label for="level">JABATAN</label>
                    <div class="input-wrapper">
                        <select id="level" name="id_level" class="form-control @error('id_level') is-invalid @enderror" required>
                            <option value="">- Pilih Jabatan -</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('id_level') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-user-shield input-icon"></i>
                    </div>
                    @error('id_level')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2 pt-3 border-top">
            <button type="reset" class="btn-register-reset">
                Reset
            </button>
            <button type="submit" class="btn-register-action" id="btnRegister">
                <span>Daftar</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div class="text-center mt-3 pt-2 border-top">
            <span style="color: #64748B; font-size: 0.875rem;">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" style="color: var(--auth-primary); font-weight: 700; font-size: 0.875rem; text-decoration: none; margin-left: 4px;">
                Masuk
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleRegPassBtn');
            const passInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirmation');
            const toggleIcon = document.getElementById('toggleRegPassIcon');
            const strengthFill = document.getElementById('strengthFill');
            const strengthLabel = document.getElementById('strengthLabel');
            const matchLabel = document.getElementById('matchLabel');

            if (toggleBtn && passInput && toggleIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passInput.getAttribute('type') === 'password';
                    passInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }

            if (passInput) {
                passInput.addEventListener('input', function() {
                    const val = passInput.value;
                    let score = 0;
                    if (val.length >= 6) score += 30;
                    if (val.length >= 10) score += 20;
                    if (/[A-Z]/.test(val)) score += 25;
                    if (/[0-9]/.test(val)) score += 25;

                    strengthFill.style.width = score + '%';
                    if (score === 0) {
                        strengthLabel.textContent = '';
                        strengthFill.style.backgroundColor = '#E2E8F0';
                    } else if (score < 50) {
                        strengthLabel.textContent = 'Strength: Weak';
                        strengthLabel.style.color = '#EF4444';
                        strengthFill.style.backgroundColor = '#EF4444';
                    } else if (score < 80) {
                        strengthLabel.textContent = 'Strength: Medium';
                        strengthLabel.style.color = '#F4A623';
                        strengthFill.style.backgroundColor = '#F4A623';
                    } else {
                        strengthLabel.textContent = 'Strength: Strong';
                        strengthLabel.style.color = '#10B981';
                        strengthFill.style.backgroundColor = '#10B981';
                    }
                    checkMatch();
                });
            }

            if (confirmInput) {
                confirmInput.addEventListener('input', checkMatch);
            }

            function checkMatch() {
                if (!confirmInput.value) {
                    matchLabel.textContent = '';
                    return;
                }
                if (passInput.value === confirmInput.value) {
                    matchLabel.textContent = '✓ Password Cocok';
                    matchLabel.style.color = '#10B981';
                } else {
                    matchLabel.textContent = '✕ Konfirmasi Password Tidak Cocok';
                    matchLabel.style.color = '#EF4444';
                }
            }

            const regForm = document.getElementById('registerForm');
            const btnReg = document.getElementById('btnRegister');
            if (regForm && btnReg) {
                regForm.addEventListener('submit', function() {
                    btnReg.disabled = true;
                    btnReg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mendaftarkan...</span>';
                });
            }
        });
    </script>
@endpush
