 <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start col-12" id="menu">
                    <li class="{{ (request()->is('/*')) ? 'active' : '' }}">
                        <a href="/" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>

                    <li class="{{ (request()->is('users')) ? 'active' : '' }}">
                        <a href="{{ route('users.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Usuarios</span> </a>
                    </li>
                    <li class="{{ (request()->is('roles') || request()->is('roles/create') || request()->is('roles/*') || request()->is('roles/*/edit')) ? 'active' : '' }}">
                        <a href="{{ route('roles.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Roles</span></a>
                    </li>
                    <li class="{{ (request()->is('projects')) ? 'active' : '' }}"> 
                        <a href="{{ route('projects.index')}}" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-folder-fill"></i> <span class="ms-1 d-none d-sm-inline">Proyectos</span></a>
                    </li class="{{ (request()->is('reportes')) ? 'active' : '' }}">
                                        <li>
                        <a href="#" class="nav-link px-3 align-middle">
                            <i class="fs-4 bi-bar-chart-line"></i> <span class="ms-1 d-none d-sm-inline">Reportes</span></a>
                    </li>
                </ul>