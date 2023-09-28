@section('title', 'Relatório')
<div class="w-[100%]">
    <div class="flex flex-col overflow-x-auto w-[100%] min-w-fit border-2 border-black rounded-t-lg mt-6">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  min-w-fit " x-data="{ open: false }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-history text-xl mx-2"> </i>
                <span class="font-bold text-xl">A pagar</span>
            </div>
            <div class="w-full" x-show="open" x-transition>
                <table class="w-full min-w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th class="border-r" scope="col">#</th>
                        <th class="border-r" scope="col">Custo</th>
                        <th class="border-r" scope="col">Venda</th>
                        <th class="border-r" scope="col">Cliente</th>
                        <th class="border-r" scope="col">Data</th>
                        <th class="" scope="col">Total:</th>
                        <th class="border-r" scope="col">R$ {{$total}}</th>
                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach($unconfirmedSale as $sale)
                        <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                            <td class="whitespace-nowrap px-2 py-4 border-r">{{ $sale->id  }}</td>
                            <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->cost  }}</td>
                            <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->price  }}</td>
                            <td class="whitespace-nowrap px-2 py-4 border-r">{{ $sale->customer_name  }}</td>
                            <td class="whitespace-nowrap px-2 py-4 border-r">{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>
                            <td class="whitespace-nowrap px-2 py-4 ">
                                <x-button  class="w-full" info label="Detalhes"/>
                            </td>
                            <td class="whitespace-nowrap px-2 py-4 border-r ">
                                <x-button class="w-full" positive label="Confirmar" wire:click="confirmSale({{$sale->id}})" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  min-w-fit " x-data="{ open: true }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-check text-xl mx-2"> </i>
                <span class="font-bold text-xl">Pago</span>
            </div>
            <div class="w-full" x-show="open" x-transition>
                <table class="w-full min-w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th class="border-r" scope="col">#</th>
                        <th class="border-r" scope="col">Custo</th>
                        <th class="border-r" scope="col">Venda</th>
                        <th class="border-r" scope="col">Lucro</th>
                        <th class="border-r" scope="col">Cliente</th>
                        <th class="border-r" scope="col">Data</th>
                        <th class="border-r" scope="col"></th>

                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach($sales as $sale)
                    <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                        <td class="whitespace-nowrap px-2 py- border-r">{{ $sale->id  }}</td>
                        <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->cost  }}</td>
                        <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->price  }}</td>
                        <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->price - $sale->cost  }}</td>
                        <td class="whitespace-nowrap px-2 py-4 border-r">{{ $sale->customer_name  }}</td>
                        <td class="whitespace-nowrap px-2 py-4 border-r">{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>

                        <td class="whitespace-nowrap px-2 py-4 border-r ">
                            <x-button class="w-full" info label="Detalhes"/>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $sales->links() }}
            </div>
        </div>

    </div>
</div>
