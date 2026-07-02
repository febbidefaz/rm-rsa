<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    @if (config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    <div class="sidebar">

        @if (session('user_rm_id'))
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">

                <div class="img-circle elevation-2 d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;background:#0F766E;color:#fff;font-size:18px;">
                    <i class="fas fa-hospital-user"></i>
                </div>

                <div class="info">
                    <a href="#" class="d-block text-white font-weight-bold">
                        {{ session('user_rm_nama') }} </a>

                </div>

            </div>
        @endif

        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if (config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if (!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>

                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')

            </ul>
        </nav>
    </div>
</aside>


<style>
    .user-panel-rm {
        margin: 18px 10px 22px 10px;
        padding: 16px 14px;
        display: flex;
        align-items: center;
        gap: 14px;
        background: linear-gradient(135deg, #0F766E, #0F766E);
        border-radius: 10px;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
    }

    .user-icon-rm {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 24px;
        background: rgba(255, 255, 255, 0.15);
    }

    .user-info-rm {
        color: #ffffff;
        line-height: 1.2;
    }

    .user-name-rm {
        font-size: 18px;
        font-weight: 600;
    }

    .user-role-rm {
        margin-top: 4px;
        font-size: 14px;
        opacity: 0.85;
    }

    .nav-sidebar .nav-item>.nav-link.active {
        background-color: #0F766E !important;
        color: #ffffff !important;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(15, 118, 110, 0.35);
    }

    .nav-sidebar .nav-item>.nav-link.active i {
        color: #ffffff !important;
    }

    .nav-sidebar .nav-item>.nav-link:hover {
        background-color: rgba(15, 118, 110, 0.18) !important;
        color: #ffffff !important;
    }

    .nav-sidebar .nav-treeview>.nav-item>.nav-link.active {
        background-color: #0F766E !important;
        color: #ffffff !important;
    }

    .card {
        border-radius: 15px;
        border: none;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }

    .form-control {
        border-radius: 10px;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #0F766E;
        box-shadow: 0 0 0 .15rem rgba(40, 167, 69, .15);
    }
</style>
