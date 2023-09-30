<script src="https://unpkg.com/feather-icons"></script>
@vite(['resources/js/app.js',  'resources/css/app.css' ])
<div class="flex items-stretch">

    <!-- Sidenav -->
    <nav id="sidebar"
         class="bg-cinza fixed left-0 top-0 z-[1035] h-screen w-64      -translate-x-full         overflow-hidden         leading-6         shadow-[0_4px_12px_0_rgba(0,0,0,0.07),_0_2px_4px_rgba(0,0,0,0.05)]         data-[te-sidenav-hidden='false']:translate-x-0"
         data-te-sidenav-init
         data-te-sidenav-mode-breakpoint-over="0"
         data-te-sidenav-mode-breakpoint-side="sm"
         data-te-sidenav-hidden="false"
         data-te-sidenav-mode="side"
         data-te-sidenav-content="#content">
        <!-- links -->
        <ul class="relative m-0 list-none px-[0.2rem] font-normal  " data-te-sidenav-menu-ref>
            <div class="my-4">
                <a class="px-6 py-4 text-xl font-bold text-gray-300"
                   href="{{ route('admin.home') }}">{{config('app.name', 'Indefinido') }}</a>
            </div>
            <!--  -->
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.home') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="sliders"></i>
          </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <!--  -->
            <div class="my-4">
                <span class="px-6 py-4 text-[0.875rem] text-gray-300">Clientes</span>
            </div>
            <!--  -->
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.customer') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="user"></i>
          </span>
                    <span>Consultar</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.customer.register') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="user-plus"></i>
          </span>
                    <span>Cadastrar</span>
                </a>
            </li>

            <!--  -->
            <div class="my-4">
                <span class="px-6 py-4 text-[0.875rem] text-gray-300">Produtos</span>
            </div>

            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.inventory') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="archive"></i>
          </span>
                    <span>Estoque</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.product.register') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="plus-square"></i>
          </span>
                    <span>Cadastrar</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.product.add') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="plus-circle"></i>
          </span>
                    <span>Adicionar</span>
                </a>
            </li>
            <!--  -->
            <div class="my-4">
                <span class="px-6 py-4 text-[0.875rem] text-gray-300">Financeiro</span>
            </div>

            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.finances') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="dollar-sign"></i>
          </span>
                    <span>Finanças</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.sale') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="shopping-cart"></i>
          </span>
                    <span>Vender</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.reports') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="trello"></i>
          </span>
                    <span>Relatório</span>
                </a>
            </li>

            <!--  -->
            <div class="my-4">
                <span class="px-6 py-4 text-[0.875rem] text-gray-300">Ferramentas</span>
            </div>

            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.estatisticas') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="activity"></i>
          </span>
                    <span>Estatística </span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.shoppinglist') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="shopping-bag"></i>
          </span>
                    <span>Lista de compras</span>
                </a>
            </li>
            <li class="relative">
                <a class="a-hover a-active flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-400 outline-none transition duration-300 ease-linear motion-reduce:transition-none"
                   href="{{ route('admin.ocpack') }}">
          <span class="mr-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <i data-feather="box"></i>
          </span>
                    <span>Fardo</span>
                </a>
            </li>
        </ul>
    </nav>
    <div
        class="flex min-h-screen w-screen flex-col overflow-hidden bg-[#ced4da]  dark:bg-gray-800  dark:text-white !pl-[240px]"
        id="content">
        <header class="bg-white w-full drop-shadow-lg dark:bg-gray-800 dark:border-gray-700  z-[1035] ">
            <nav class="px-7 py-3 ">

                {{-- Hamburger--}}
                <button data-te-sidenav-toggle-ref data-te-target="#sidebar" aria-controls="#sidebar"
                        aria-haspopup="true">
                    <i data-feather="menu" class=""></i>
                </button>
                {{-- Menu --}}
                <div class="float-right">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <i data-feather="settings" class="w-auto h-auto"></i>
                        </x-slot>

                        <x-dropdown.header label="Settings">
                            <x-dropdown.item icon="moon" class="dark-toogle">
                                Dark mode
                            </x-dropdown.item>
                            <x-dropdown.item icon="cog" label="Preferences" href="{{ route('admin.settings') }}"/>
                            <x-dropdown.item icon="user" label="History"/>
                        </x-dropdown.header>

                        <x-dropdown.item separator/>

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown.item icon="logout" label="Logout" @click.prevent="$root.submit();"/>
                        </form>

                    </x-dropdown>
                </div>
            </nav>
        </header>

        <div class="flex p-12 justify-center">

            <x-dialog z-index="z-50" blur="md" align="center"/>
            @yield('content')

        </div>
    </div>
</div>

<script>
    feather.replace()
</script>
