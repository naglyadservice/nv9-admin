<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Управление</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">Управление</li>

                <li class="nav-item">
                    <a href="{{route('devices')}}" class="nav-link @if(Route::currentRouteName() == 'devices') active @endif">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Устройства</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('partners')}}" class="nav-link @if(Route::currentRouteName() == 'partners') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Партнеры</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('fiscalization')}}" class="nav-link @if(Route::currentRouteName() == 'fiscalization') active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Фискализация</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('payment-gateway.index')}}" class="nav-link @if(Route::currentRouteName() == 'payment-gateway.index') active @endif">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>Платежные системы</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('reports')}}" class="nav-link @if(Route::currentRouteName() == 'reports') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Отчёты</p>
                    </a>
                </li>

                <li class="nav-header">Аккаунт</li>

                <li class="nav-item">
                    <a href="{{route('account.logout')}}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Выйти</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
