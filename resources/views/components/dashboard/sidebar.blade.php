<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        @php
        $title = Main::GetSetting('title');
        $word = explode(' ', $title);

        $_ac = "";

        foreach ($word as $w) {
        $_ac .= mb_substr($w, 0, 1);
        }
        @endphp
        <div class="sidebar-brand-icon rotate-n-15 d-md-none">
            {{ $_ac }}
        </div>
        <div class="sidebar-brand-text mx-3">{{ Main::GetSetting('title') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    @php
    $listMenu = Main::GetListManu();
    @endphp

    @foreach ($listMenu as $menu)
    @if($menu->subMenu)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{ Main::md5($menu->menu_url) }}" aria-expanded="true" aria-controls="{{ Main::md5($menu->menu_url) }}">
            <i class="{{ $menu->menu_icon }}"></i>
            <span>{{ $menu->menu_title }}</span>
        </a>
        <div id="{{ Main::md5($menu->menu_url) }}" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach($menu->subMenu as $subMenu)
                <a class="collapse-item" href="{{ url($subMenu->menu_url) }}">
                    <i class="{{ $subMenu->menu_icon }}"></i>
                    {{ $subMenu->menu_title }}
                </a>
                @endforeach
            </div>
        </div>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link" href="{{ url($menu->menu_url) }}">
            <i class="{{ $menu->menu_icon }}"></i>
            <span>{{ $menu->menu_title }}</span>
        </a>
    </li>
    @endif
    @endforeach
</ul>
