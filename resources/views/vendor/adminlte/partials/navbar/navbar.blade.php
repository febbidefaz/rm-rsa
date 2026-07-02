@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')
        @yield('content_top_nav_left')
    </ul>

    <ul class="navbar-nav ml-auto">
        @yield('content_top_nav_right')

        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user-circle mr-1"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <span class="dropdown-item dropdown-header">
                    <strong>{{ session('user_rm_nama', 'User') }}</strong><br>
                </span>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); $('.dropdown-menu').removeClass('show'); $('#modalGantiPassword').modal('show');">
                    <i class="fas fa-user-edit mr-2"></i>
                    Update Profile
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item text-center text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off mr-1"></i>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('rm.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>

            </div>
        </li>
    </ul>
</nav>

@if (session('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show"
        style="position: fixed; top: 70px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>

    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 3000);
    </script>
@endif

@if ($errors->any())
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show"
        style="position: fixed; top: 70px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>

    <script>
        setTimeout(function() {
            $('#errorAlert').fadeOut('slow');
        }, 3000);
    </script>
@endif

<div class="modal fade" id="modalGantiPassword" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header text-white" style="background:#0F766E;">
                <h5 class="modal-title">
                    <i class="fas fa-key mr-2"></i>
                    Ganti Password
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ session('user_rm_id') }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group mb-0">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_baru_confirmation" class="form-control form-control-sm"
                            required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-sm text-white"
                        style="background:#0F766E;border-color:#0F766E;">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#modalGantiPassword').on('shown.bs.modal', function() {
        $('.dropdown-menu').removeClass('show');
    });
</script>
