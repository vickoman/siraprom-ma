 <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start col-12" id="menu">
    @can('avance-create')
                    <li class="{{ (request()->is('/*')) ? 'active' : '' }}">
                        <a href="/" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1  d-sm-inline">Dashboard</span> </a>
                    </li>
    @endcan
                    @can('user-list')
                    <li class="{{ (request()->is('users') || request()->is('users/create') || request()->is('users/*')) ? 'active' : '' }}">
                        <a href="{{ route('users.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1  d-sm-inline">Usuarios</span> </a>
                    </li>
                    @endcan
                    @can('role-list')
                    <li class="{{ (request()->is('roles') || request()->is('roles/create') || request()->is('roles/*')) ? 'active' : '' }}">
                        <a href="{{ route('roles.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1  d-sm-inline">Roles</span></a>
                    </li>
                    @endcan
                    @can('project-list')
                    <li class="{{ (request()->is('projects') || request()->is('projects/*')) ? 'active' : '' }}"> 
                        <a href="{{ route('projects.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-folder-fill"></i> <span class="ms-1  d-sm-inline">Proyectos</span></a>
                    </li>
                    @endcan
                        @can('avance-create')
                     <li class="{{ (request()->is('reports')) ? 'active' : '' }}">
                        <a href="/reports" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi bi-download"></i> <span class="ms-1  d-sm-inline">Reportes</span></a>
                    </li>
                    @endcan
                        @can('avance-create')
                     <li class="{{ (request()->is('indicators')) ? 'active' : '' }}">
                        <a href="/indicators" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-bar-chart-line"></i> <span class="ms-1  d-sm-inline">Indicadores</span></a>
                    </li>
                    @endcan
                </ul>