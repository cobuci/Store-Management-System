@section('title', 'Clientes')
<div class="flex flex-col w-full">
    <h1 class="grid justify-items-center font-bold text-2xl mb-6 w-full"> Clientes</h1>
    <div
        class="flex flex-col bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 items-center justify-center drop-shadow-xl w-full min-w-fit">
        <div class="w-full">
            <x-input class="w-full mb-4" type="text" wire:model.live="search" placeholder="Pesquisar" />
        </div>

        <div class="w-full items-center">


            <table class="w-full dark:bg-gray-800 my-2 rounded-md p-2  ">
                <tr>
                    <thead class="" >
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Valor Devido</th>
                        <th>Opções</th>
                    </thead>
                </tr>
                <tbody class="dark:bg-gray-800 my-2 rounded-md">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-900 flex-1 cursor-default">
                         
                            <td class="pl-4"> {{ $customer->id }} </td>
                            <td> {{ $customer->name }}</td>
                            <td> {{ $customer->street }}</td>
                            <td> R$ {{ $customer->debit()}}</td>
                            <td class="px-4">
                                <x-button class="w-full" label="Verificar" wire:click="customerProfile({{$customer->id}})" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>

</div>
