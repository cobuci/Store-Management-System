<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('title')</title>

    @livewireStyles

    <link href="{{ asset('admin/select2.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="{{ asset('admin/app.css') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
    <script src="{{ url(mix('admin/script.js')) }}"></script>

    <script src="{{ asset('admin/jquery.js') }}"></script>
</head>

<body id="page-top">
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{ route('admin.home') }}">
                    <span class="align-middle">Garagem 46</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-item {{ Route::current()->getName() === 'admin.home' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="sliders"></i>
                            <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-header">Clientes</li>

                    <li class="sidebar-item  {{ Route::current()->getName() === 'admin.cliente' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.cliente') }}">
                            <i class="align-middle" data-feather="user"></i>
                            <span class="align-middle">Consultar</span>
                        </a>
                    </li>

                    <li
                        class="sidebar-item  {{ Route::current()->getName() === 'admin.clienteCadastro' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.clienteCadastro') }}">
                            <i class="align-middle" data-feather="user-plus"></i>
                            <span class="align-middle">Cadastrar</span>
                        </a>
                    </li>

                    <li class="sidebar-header">Produtos</li>

                    <li class="sidebar-item {{ Route::current()->getName() === 'admin.estoque' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.estoque') }}">
                            <i class="align-middle" data-feather="archive"></i>
                            <span class="align-middle">Estoque</span>
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

                    <li class="sidebar-item {{ Route::current()->getName() === 'admin.relatorio' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.relatorio') }}">
                            <i class="align-middle" data-feather="trello"></i>
                            <span class="align-middle">Relatório de Vendas</span>
                        </a>
                    </li>

                    <li
                        class="sidebar-item {{ Route::current()->getName() === 'admin.relatorio.descontinuado' ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.relatorio.descontinuado') }}">
                            <i class="align-middle" data-feather="trello"></i>
                            <span class="align-middle">Relatório Descontinuado</span>
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
                                <img src="{{ asset('images/nina1.png') }}" class="avatar img-fluid rounded me-1" />
                                <span class="text-dark">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.historico') }}">
                                    <i class="align-middle me-1" data-feather="pie-chart"></i>
                                    Histórico
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                        class="dropdown-item" type="submit" title="Deslogar">Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content ">
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
    <script src="{{ asset('admin/app2.js') }}"></script>
    <script src="{{ asset('admin/jquery.js') }}"></script>
    

</body>

</html>
