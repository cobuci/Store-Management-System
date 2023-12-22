@section('title', 'Clientes')
<div class="flex w-full max-w-4xl select-none flex-col">
    <h1 class="mb-6 grid w-full justify-items-center text-2xl font-bold"> Clientes</h1>
    <div
        class="flex w-full flex-col items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] dark:bg-gray-700">
        <div class="w-full">
            <x-input class="mb-4 w-full" type="text" wire:model.live="search" placeholder="Pesquisar"/>
        </div>

        <div class="w-full overflow-auto">
            <table class="my-2 w-full whitespace-nowrap rounded-md p-2 dark:bg-gray-800">
                <tr>
                    <thead class="">
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Valor Devido</th>
                    <th>Opções</th>
                    </thead>
                </tr>
                <tbody class="my-2 rounded-md dark:bg-gray-800">
                @foreach ($customers as $customer)
                    <tr class="flex-1 cursor-default hover:bg-gray-200 dark:hover:bg-gray-900">
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
