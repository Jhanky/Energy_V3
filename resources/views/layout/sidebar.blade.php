<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        @auth
        <a class="navbar-brand m-0" href="/home" target="_blank">
            <h4 class="font-weight-bold text-white">Enterprise V2</h4>
        </a>
        @endauth
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('home') ? 'active bg-gradient-success' : '' }}" href="/public/home">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('COMERCIAL'))
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('clientes') ? 'active bg-gradient-success' : '' }}" href="/public/clientes">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">group</i>
                    </div>
                    <span class="nav-link-text ms-1">Clientes</span>
                </a>
            </li>

            <div class="dropdown">

                <a href="#" class="nav-link text-white dropdown-toggle {{ Request::is('cotizaciones','cotizacionesF') ? 'active bg-gradient-success' : '' }}" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Cotizaciones</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                    <li>
                        <a class="dropdown-item" href="/public/cotizaciones">
                            <img src="https://img.freepik.com/vector-premium/celda-panel-solar-sobre-fondo-blanco-vector_273456-76.jpg?w=30" /> Normales
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/public/cotizacionesF">
                            <img src="https://img.freepik.com/free-vector/consultative-selling-abstract-concept-vector-illustration-consultative-sales-approach-selling-process-salesman-coaching-corporate-representative-consultation-process-broker-abstract-metaphor_335657-2888.jpg?w=30" /> Financiadas
                        </a>
                    </li>
                </ul>
            </div>
            
            <li class="nav-item">

                <a class="nav-link text-white {{ Request::is('proyectos') ? 'active bg-gradient-success' : '' }}" href="/public/proyectos">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">folder</i>
                    </div>
                    <span class="nav-link-text ms-1">Proyectos</span>
                </a>
            </li>
            @endif


            @if(auth()->user()->hasRole('ADMINISTRADOR'))
            <div class="dropdown">
                <a href="#" class="nav-link text-white dropdown-toggle {{ Request::is('paneles','inversores','baterias','cables') ? 'active bg-gradient-success' : '' }}" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">Productos</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                    <li>
                        <a class="dropdown-item" href="/public/paneles">
                            <img src="https://img.freepik.com/vector-premium/celda-panel-solar-sobre-fondo-blanco-vector_273456-76.jpg?w=30" /> Panel solar
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/public/inversores">
                            <img src="https://img.freepik.com/fotos-premium/inversor-solar-fotovoltaico-3d-aislado-sobre-fondo-blanco-espacio-texto_88235-640.jpg?w=30" /> Inversor
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <img src="https://img.freepik.com/fotos-premium/inversor-solar-fotovoltaico-3d-aislado-sobre-fondo-blanco-espacio-texto_88235-640.jpg?w=30" /> Micro inversor
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/public/baterias">
                            <img src="https://img.freepik.com/vector-premium/concepto-infografico-paneles-solares-ahorrar-energia_999616-1622.jpg?w=30" /> Batería
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <img src="https://img.freepik.com/fotos-premium/bobina-madera-cable-electrico-negro-aislado-fondo-blanco-ilustracion-3d_394271-247.jpg?w=30" /> Conductor fotovoltaico
                        </a>
                    </li>
                </ul>
            </div>
              <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('usuarios') ? 'active bg-gradient-success' : '' }}" href="/public/usuarios">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Usuarios</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('TECNICO'))
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('visitas') ? 'active bg-gradient-success' : '' }}" href="/public/visitas">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home_work</i>
                    </div>
                    <span class="nav-link-text ms-1">Visitas</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>