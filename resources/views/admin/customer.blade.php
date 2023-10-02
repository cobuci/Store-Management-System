@section('title', 'Clientes')
<div class="flex flex-col w-full">
    <h1 class="grid justify-items-center font-bold text-2xl mb-6 w-full"> Clientes</h1>
    <div
        class="flex flex-col bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 items-center justify-center drop-shadow-xl w-full">
        <div class="w-full">
            <x-input class="w-full mb-4" type="text" wire:model.live="search" placeholder="Pesquisar"/>
        </div>

        <div class="w-full overflow-auto">
            <table class="w-full dark:bg-gray-800 my-2 rounded-md p-2 whitespace-nowrap ">
                <tr>
                    <thead class="">
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Valor Devido</th>
                    <th>Opções</th>
                    </thead>
                </tr>
                <tbody class="dark:bg-gray-800 my-2 rounded-md">
                @foreach ($customers as $customer)
                    <tr class="dark:hover:bg-gray-900 hover:bg-gray-200 flex-1 cursor-default">

                        <td class="px-4"> {{ $customer->id }} </td>
                        <td> {{ $customer->name }}</td>
                        <td> {{ $customer->street }}</td>
                        <td> R$ {{ $customer->debit() }}</td>
                        <td class="px-4">
                            <x-button primary class="w-full" label="Verificar"
                                      wire:click="customerProfile({{ $customer->id }})"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $customers->links() }}
    </div>

</div>
