<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{__('Управління')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">{{__('Управління')}}</li>

                <li class="nav-item">
                    <a href="{{route('devices')}}" class="nav-link @if(Route::currentRouteName() == 'devices') active @endif">
                        <i class="nav-icon fas fa-list"></i>
                        <p>{{__('Пристрої')}}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('partners')}}" class="nav-link @if(Route::currentRouteName() == 'partners') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{__('Партнери')}}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('fiscalization')}}" class="nav-link @if(Route::currentRouteName() == 'fiscalization') active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p>{{__('Фіскалізація')}}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('payment-gateway.index')}}" class="nav-link @if(Route::currentRouteName() == 'payment-gateway.index') active @endif">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>{{__('Платіжні системи')}}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('reports')}}" class="nav-link @if(Route::currentRouteName() == 'reports') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>{{__('Звіти')}}</p>
                    </a>
                </li>

                <li class="nav-header">{{__('Обліковий запис')}}</li>

                <li class="nav-item">
                    <a href="{{route('account.logout')}}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>{{__('Вийти')}}</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
