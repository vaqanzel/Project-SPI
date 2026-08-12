{{-- SPI POLINEMA — Modern Enterprise Topbar / Header v2.0 --}}
{{-- PENTING: Semua data backend (auth()->user()->name, id_level, routes) TIDAK diubah --}}

<div class="navbar-bg" style="display:none;"></div>

<nav class="navbar navbar-expand-lg main-navbar" style="background:#fff; border-bottom:1px solid #E2E8F0; box-shadow:0 1px 3px rgba(0,0,0,0.05); height:70px; padding:0 28px;">

    {{-- ─── Left: Hamburger + Breadcrumb ─── --}}
    <div class="d-flex align-items-center" style="gap:12px;">
        {{-- Hamburger (mobile) --}}
        <button data-toggle="sidebar" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:10px; background:transparent; border:none; cursor:pointer; color:#64748B; font-size:1rem; transition:all 0.15s ease;" 
                onmouseover="this.style.background='#F1F5F9'; this.style.color='#173F9E';" 
                onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Page context breadcrumb - dynamically inferred from URL --}}
        <div class="d-none d-md-flex align-items-center" style="gap:6px; font-size:0.8rem; color:#94A3B8;">
            <a href="{{ url('/dashboard') }}" style="color:#94A3B8; text-decoration:none; transition:color 0.15s;" 
               onmouseover="this.style.color='#173F9E';" onmouseout="this.style.color='#94A3B8';">
                <i class="fas fa-home" style="font-size:0.75rem;"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:0.5rem; color:#CBD5E1;"></i>
            <span style="color:#334155; font-weight:600;">@yield('title', 'Dashboard')</span>
        </div>
    </div>

    {{-- ─── Right: User Dropdown ─── --}}
    <ul class="navbar-nav navbar-right ml-auto" style="list-style:none; margin:0; padding:0;">
        <li class="dropdown" style="position:relative;">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle d-flex align-items-center"
               style="gap:10px; padding:6px 10px; border-radius:10px; color:#334155; text-decoration:none; transition:all 0.15s ease; border:none; background:transparent;"
               onmouseover="this.style.background='#F1F5F9';" 
               onmouseout="this.style.background='transparent';">

                {{-- Avatar --}}
                @if (auth()->user()->profile_picture)
                    <img alt="{{ auth()->user()->name }}"
                         src="/profile_pictures/{{ auth()->user()->profile_picture }}"
                         style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #E2E8F0; flex-shrink:0;">
                @else
                    {{-- Initials Avatar --}}
                    @php
                        $nameParts = explode(' ', auth()->user()->name);
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                    @endphp
                    <div style="width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#173F9E,#0f2d74); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; flex-shrink:0; letter-spacing:-0.01em;">
                        {{ $initials }}
                    </div>
                @endif

                {{-- User Info (desktop) --}}
                <div class="d-none d-md-flex flex-column" style="line-height:1.2; min-width:0;">
                    <span style="font-size:0.84rem; font-weight:700; color:#1E293B; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">{{ auth()->user()->name }}</span>
                    <span style="font-size:0.72rem; color:#94A3B8; font-weight:500;">
                        @switch(auth()->user()->id_level)
                            @case(1) Super Administrator @break
                            @case(2) Administrator @break
                            @case(3) Ketua @break
                            @case(4) Anggota @break
                            @case(5) Auditee @break
                            @case(6) Sekretaris @break
                            @default Unknown
                        @endswitch
                    </span>
                </div>

                <i class="fas fa-chevron-down d-none d-md-block" style="font-size:0.65rem; color:#94A3B8; margin-left:2px;"></i>
            </a>

            {{-- Dropdown Menu --}}
            <div class="dropdown-menu dropdown-menu-right"
                 style="border:1px solid #E2E8F0; border-radius:14px; box-shadow:0 8px 30px rgba(15,23,53,0.12); min-width:210px; padding:6px; margin-top:8px; overflow:hidden; animation:fadeDropIn 0.18s ease;">

                {{-- User info header in dropdown --}}
                <div style="padding:10px 12px 10px; border-bottom:1px solid #F1F5F9; margin-bottom:4px;">
                    <div style="font-size:0.82rem; font-weight:700; color:#0F172A;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.72rem; color:#94A3B8; margin-top:1px;">
                        @switch(auth()->user()->id_level)
                            @case(1) Super Administrator @break
                            @case(2) Administrator @break
                            @case(3) Ketua @break
                            @case(4) Anggota @break
                            @case(5) Auditee @break
                            @case(6) Sekretaris @break
                            @default Unknown
                        @endswitch
                    </div>
                </div>

                <a href="{{ route('profileDataUser', Auth::user()->id) }}" class="dropdown-item"
                   style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#475569; font-size:0.83rem; font-weight:500; transition:all 0.12s ease; text-decoration:none;"
                   onmouseover="this.style.background='#F8FAFC'; this.style.color='#173F9E';"
                   onmouseout="this.style.background='transparent'; this.style.color='#475569';">
                    <i class="far fa-user" style="width:16px; text-align:center; font-size:0.85rem;"></i>
                    <span>Profil Saya</span>
                </a>

                <a href="{{ route('manualbook') }}" class="dropdown-item"
                   style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#475569; font-size:0.83rem; font-weight:500; transition:all 0.12s ease; text-decoration:none;"
                   onmouseover="this.style.background='#F8FAFC'; this.style.color='#173F9E';"
                   onmouseout="this.style.background='transparent'; this.style.color='#475569';">
                    <i class="fas fa-book" style="width:16px; text-align:center; font-size:0.85rem;"></i>
                    <span>Manualbook &amp; Peraturan</span>
                </a>

                <a href="/feedback" class="dropdown-item"
                   style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#475569; font-size:0.83rem; font-weight:500; transition:all 0.12s ease; text-decoration:none;"
                   onmouseover="this.style.background='#F8FAFC'; this.style.color='#173F9E';"
                   onmouseout="this.style.background='transparent'; this.style.color='#475569';">
                    <i class="fas fa-comment" style="width:16px; text-align:center; font-size:0.85rem;"></i>
                    <span>Feedback</span>
                </a>

                <div style="height:1px; background:#F1F5F9; margin:4px 0;"></div>

                <a href="{{ route('logout') }}" class="dropdown-item"
                   style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#EF4444; font-size:0.83rem; font-weight:600; transition:all 0.12s ease; text-decoration:none;"
                   onmouseover="this.style.background='#FEE2E2';"
                   onmouseout="this.style.background='transparent';">
                    <i class="fas fa-sign-out-alt" style="width:16px; text-align:center; font-size:0.85rem;"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
</nav>

<style>
    @keyframes fadeDropIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
