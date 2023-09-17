<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="{{ route('admin.home') }}">
                <span class="align-middle">{{config('app.name', 'Indefinido') }}</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-item {{ Route::current()->getName() === 'admin.home' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.home') }}">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-header">Clientes</li>

                <li class="sidebar-item  {{ Route::current()->getName() === 'admin.customer' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.customer') }}">
                        <i class="align-middle" data-feather="user"></i>
                        <span class="align-middle">Consultar</span>
                    </a>
                </li>

                <li
                    class="sidebar-item  {{ Route::current()->getName() === 'admin.customer.register' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.customer.register') }}">
                        <i class="align-middle" data-feather="user-plus"></i>
                        <span class="align-middle">Cadastrar</span>
                    </a>
                </li>

                <li class="sidebar-header">Produtos</li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.inventory' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.inventory') }}">
                        <i class="align-middle" data-feather="archive"></i>
                        <span class="align-middle">Estoque</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.cadastrar' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.cadastrar') }}">
                        <i class="align-middle" data-feather="plus-square"></i>
                        <span class="align-middle">Cadastrar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.entrada' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.entrada') }}">
                        <i class="align-middle" data-feather="plus-circle"></i>
                        <span class="align-middle">Adicionar</span>
                    </a>
                </li>

                <li class="sidebar-header">Financeiro</li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.financas' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.financas') }}">
                        <i class="align-middle" data-feather="dollar-sign"></i>
                        <span class="align-middle">Finanças</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.vender' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.vender') }}">
                        <i class="align-middle" data-feather="shopping-cart"></i>
                        <span class="align-middle">Vender</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.reports' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.reports') }}">
                        <i class="align-middle" data-feather="trello"></i>
                        <span class="align-middle">Relatório de Vendas</span>
                    </a>
                </li>


                <li class="sidebar-header">Ferramentas</li>

                <li class="sidebar-item {{ Route::current()->getName() === 'admin.ocpack' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.ocpack') }}">
                        <i class="align-middle" data-feather="box"></i>
                        <span class="align-middle">Fardo</span>
                    </a>
                </li>


                <li
                    class="sidebar-item {{ Route::current()->getName() === 'admin.shoppinglist' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.shoppinglist') }}">
                        <i class="align-middle" data-feather="shopping-bag"></i>
                        <span class="align-middle">Lista de Compras</span>
                    </a>
                </li>


                <li
                    class="sidebar-item {{ Route::current()->getName() === 'admin.estatisticas' ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.estatisticas') }}">
                        <i class="align-middle" data-feather="activity"></i>
                        <span class="align-middle">Estatisticas</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main" style="background-color: #e2ebff">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                           data-bs-toggle="dropdown">
                            <i class="align-middle" data-feather="settings"></i>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                           data-bs-toggle="dropdown">
                            <img src="{{ asset('images/nina1.png') }}" class="avatar img-fluid rounded me-1"/>
                            <span class="text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('admin.historico') }}">
                                <i class="align-middle me-1" data-feather="pie-chart"></i>
                                Histórico
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.settings') }}">
                                <i class="align-middle me-1" data-feather="settings"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                        class="dropdown-item" type="submit" title="Deslogar">Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="content">
            <div class="container-fluid p-0 ">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">@yield('page-name')</h1>
                </div>

                @yield('content')

                <a class="scroll-to-top rounded " href="#page-top">
                    <i class="align-end" data-feather="chevrons-up"></i>
                </a>
            </div>
        </main>
    </div>
</div>
