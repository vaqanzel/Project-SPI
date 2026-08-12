{{-- SPI POLINEMA — Modern Enterprise Sidebar v2.0 --}}
{{-- PENTING: Semua logika PHP (level_menu, head_menus, panel_menus, auth) TIDAK diubah --}}

<aside class="main-sidebar sidebar-style-2 spi-sidebar-wrap" id="spi-sidebar">
    <div id="sidebar-wrapper">

        {{-- ─── Brand / Logo ─── --}}
        <div class="sidebar-brand" style="background:#fff; border-bottom:1px solid #E2E8F0; height:70px; display:flex; align-items:center; padding:0 20px; gap:12px;">
            <div style="width:36px; height:36px; background:linear-gradient(135deg,#173F9E,#0f2d74); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 10px rgba(23,63,158,0.3);">
                <i class="fas fa-shield-halved" style="color:#fff; font-size:0.95rem;"></i>
            </div>
            <div style="line-height:1.1;">
                <div style="font-size:0.95rem; font-weight:800; color:#0F172A; letter-spacing:-0.02em;">SPI POLINEMA</div>
                <div style="font-size:0.65rem; color:#94A3B8; font-weight:500;">Internal Audit System</div>
            </div>
        </div>

        {{-- ─── Navigation ─── --}}
        <ul class="sidebar-menu" style="padding:14px 10px; list-style:none; margin:0;">
            @php
                $currentPanelActive = $active ?? null;
            @endphp

            {{-- ─── Head Menus (Grouped Headers) ─── --}}
            @foreach ($head_menus as $head_menu)
                @php
                    $count = 0;
                @endphp
                @foreach ($head_menu->Menu as $menu)
                    @php
                        $level_menu = $menu->Level_menu->pluck('id_level')->toArray();
                    @endphp
                    @if (in_array(auth()->user()->id_level, $level_menu))
                        @php $count++; @endphp
                    @endif
                @endforeach

                @if ($count > 0)
                    {{-- Section Label --}}
                    <li style="list-style:none; padding:12px 10px 4px; font-size:0.62rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#94A3B8; margin-top:4px;">
                        <span>{{ $head_menu->name }}</span>
                    </li>

                    @foreach ($head_menu->Menu as $menu)
                        @php
                            $level_menu = $menu->Level_menu->pluck('id_level')->toArray();
                        @endphp
                        @if (in_array(auth()->user()->id_level, $level_menu))
                            @php
                                $menuPath = ltrim($menu->link, '/');
                                $isActive = Request::is($menuPath) ? 'active' : '';
                            @endphp
                            <li class="{{ $isActive }}" style="list-style:none; margin:1px 0;">
                                <a href="{{ $menu->link }}" class="nav-link"
                                   style="display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:10px; color:{{ $isActive ? '#173F9E' : '#475569' }}; background:{{ $isActive ? '#EAF0FF' : 'transparent' }}; font-size:0.84rem; font-weight:{{ $isActive ? '600' : '500' }}; text-decoration:none; transition:all 0.15s ease;">
                                    <i class="{{ $menu->icon }}" style="width:18px; text-align:center; font-size:0.88rem; color:{{ $isActive ? '#173F9E' : '#94A3B8' }};"></i>
                                    <span>{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- ─── Panel Menus ─── --}}
            @foreach ($panel_menus as $menu)
                @php
                    $has_children = $menu->children->count() > 0;
                    $accessible_children = [];

                    if ($has_children) {
                        foreach ($menu->children as $child) {
                            $child_level_menu = $child->Level_menu->pluck('id_level')->toArray();
                            if (in_array(auth()->user()->id_level, $child_level_menu)) {
                                $accessible_children[] = $child;
                            }
                        }
                    }
                    $menuPath = ltrim($menu->link, '/');
                    $isActive = Request::is($menuPath) || $currentPanelActive == $menu->id;
                @endphp

                @if ($has_children && count($accessible_children) > 0)
                    {{-- Dropdown parent menu --}}
                    <li class="dropdown" style="list-style:none; margin:1px 0;">
                        <a href="{{ $menu->link }}" class="nav-link has-dropdown"
                           style="display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:10px; color:#475569; font-size:0.84rem; font-weight:500; text-decoration:none; transition:all 0.15s ease; cursor:pointer;">
                            <i class="{{ $menu->icon }}" style="width:18px; text-align:center; font-size:0.88rem; color:#94A3B8;"></i>
                            <span class="menu-text" style="flex:1;">{{ $menu->name }}</span>
                            <i class="fas fa-angle-left right" style="font-size:0.7rem; color:#94A3B8;"></i>
                        </a>
                        <ul class="dropdown-menu" style="list-style:none; padding:4px 0 4px 20px; margin:0;">
                            @foreach ($accessible_children as $child)
                                @php
                                    $childPath = ltrim($child->link, '/');
                                    $childActive = Request::is($childPath) ? 'active' : '';
                                @endphp
                                <li class="{{ $childActive }}" style="margin:1px 0;">
                                    <a href="{{ $child->link }}" class="nav-link"
                                       style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; color:{{ $childActive ? '#173F9E' : '#64748B' }}; background:{{ $childActive ? '#EAF0FF' : 'transparent' }}; font-size:0.8rem; font-weight:{{ $childActive ? '600' : '500' }}; text-decoration:none; transition:all 0.12s ease;">
                                        <i class="{{ $child->icon }}" style="width:16px; text-align:center; font-size:0.82rem;"></i>
                                        <span>{{ $child->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    {{-- Regular menu item --}}
                    <li class="{{ $isActive ? 'active' : '' }}" style="list-style:none; margin:1px 0;">
                        <a href="{{ $menu->link }}" class="nav-link"
                           style="display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:10px; color:{{ $isActive ? '#173F9E' : '#475569' }}; background:{{ $isActive ? '#EAF0FF' : 'transparent' }}; font-size:0.84rem; font-weight:{{ $isActive ? '600' : '500' }}; text-decoration:none; transition:all 0.15s ease;">
                            <i class="{{ $menu->icon }}" style="width:18px; text-align:center; font-size:0.88rem; color:{{ $isActive ? '#173F9E' : '#94A3B8' }};"></i>
                            <span>{{ $menu->name }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            {{-- ─── Divider before Logout ─── --}}
            <li style="height:1px; background:#E2E8F0; margin:10px 4px; list-style:none;"></li>

            {{-- ─── Logout ─── --}}
            <li style="list-style:none; margin:1px 0;">
                <a href="/logout" class="nav-link"
                   style="display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:10px; color:#EF4444; font-size:0.84rem; font-weight:500; text-decoration:none; transition:all 0.15s ease;">
                    <i class="fas fa-right-from-bracket" style="width:18px; text-align:center; font-size:0.88rem;"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
    </div>
</aside>

{{-- Hover & Active state polish via inline script --}}
<style>
    .main-sidebar .sidebar-menu > li > a:hover,
    .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu li a:hover {
        background: #EAF0FF !important;
        color: #173F9E !important;
    }

    .main-sidebar .sidebar-menu > li > a:hover i,
    .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu li a:hover i {
        color: #173F9E !important;
    }

    .main-sidebar .sidebar-menu li.active > a {
        background: #EAF0FF !important;
        color: #173F9E !important;
    }

    /* Scrollbar */
    #sidebar-wrapper::-webkit-scrollbar { width: 3px; }
    #sidebar-wrapper::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 9999px; }

    /* Sidebar footer logout hover */
    .main-sidebar .sidebar-menu li:last-child > a:hover {
        background: #FEE2E2 !important;
        color: #DC2626 !important;
    }
</style>
