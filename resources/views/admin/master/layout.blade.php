<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta property="og:type" content="">
    <link rel="stylesheet" href="{{ asset('admin/bootstrap.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @livewireStyles
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <script src="https://kit.fontawesome.com/a07ea4c2e1.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/jquery.js') }}"></script>
</head>

<body style="background-color: #8C61FF;font-family: Roboto, sans-serif;">
    <nav class="navbar navbar-dark navbar-expand-lg shadow-lg text-uppercase" id="mainNav"
        style="background-color: #3d3d3d;">
        <div class="container">
            <button data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                class="navbar-toggler text-white navbar-toggler-right text-uppercase rounded"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="fa fa-bars" style="color: #8C61FF;"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.home' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.home') }}" title="Dashboard">dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown">Clientes</a>
                        <div class="dropdown-menu dropdown-menu-dark">
                            <a class="dropdown-item" href="{{ route('admin.cliente') }}">Clientes</a>
                            <a class="dropdown-item" href="{{ route('admin.clienteCadastro') }}">Cadastrar</a>
                        </div>
                    </li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.estoque' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.estoque') }}" title="Estoque">Estoque</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.financas' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.financas') }}" title="Finanças">FINANÇAS</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.vender' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.vender') }}" title="Vender">VENDER</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.venderIfood' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.venderIfood') }}" title="iFood">IFOOD</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.relatorio' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.relatorio') }}" title="Relatório">RELATÓRIO</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ Route::current()->getName() === 'admin.historico' ? 'active' : '' }}"
                            data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom"
                            href="{{ route('admin.historico') }}" title="Histórico">HISTÓRICO</a></li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf


                    <button href="{{ route('logout') }}" @click.prevent="$root.submit();"
                        class="btn font-monospace link-light" data-bs-toggle="tooltip" data-bss-tooltip=""
                        data-bs-placement="bottom" type="submit" style="background-color: #8C61FF;" title="Deslogar">Log
                        Out</button>
                </form>
            </div>
        </div>
    </nav>
    <header style="width: 100%;height: 1em;"></header>

    @yield('content')
@livewireScripts
    <script src="{{ url(mix('admin/script.js')) }}"></script>

    <script src="{{ asset('admin/bootstrap.js') }}"></script>

</body>

</html>
