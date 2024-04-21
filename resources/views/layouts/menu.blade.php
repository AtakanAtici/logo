@php
    $company_info = \App\models\Setting::first(); 
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link d-flex align-items-center">
            <span class="app-brand-logo ">
                @if ($company_info->logo_path)
                    <img src="{{asset('storage/'.$company_info->logo_path)}}" alt="logo" style="width: 40px; height:40px">
                @endif
            </span>
        </a>
        <span class="demo menu-text ms-1">{{$company_info->company_name}}</span>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{isActive('dashboard')}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-home"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{isActive('current.list')}}">
            <a href="{{ route('current.list') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-list"></i>
                <div>Cari Listesi</div>
            </a>
        </li>
        <li class="menu-item {{isActive('stock.list')}}">
            <a href="{{ route('stock.list') }}" class="menu-link ">
                <i class="menu-icon fa-solid fa-cart-flatbed-suitcase"></i>
                <div>Stok Listesi</div>
            </a>
        </li>
        <li class="menu-item {{isActive('user.list')}}">
            <a href="{{ route('user.list') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-users"></i>
                <div>Kullanıcı Yonetimi</div>
            </a>
        </li>
        @can('view_order')
            <li class="menu-item {{isActive('order.list')}}">
                <a href="{{ route('order.list') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-chart-simple"></i>
                    <div>Sipariş Yönetimi</div>
                </a>
            </li>    
        @endcan
        
        <li class="menu-item {{isActive('role.list')}}">
            <a href="{{ route('role.list') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-shield-halved"></i>
                <div>Rol Yönetimi</div>
            </a>
        </li>

        <li class="menu-item {{isActive('settings')}}">
            <a href="{{ route('settings') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-gear"></i>
                <div>Ayarlar</div>
            </a>
        </li>

    </ul>
</aside>
