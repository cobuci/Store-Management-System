@php use Carbon\Carbon; @endphp
@section('title', 'Relatório')
<div class="w-full select-none">
    <h1 class="mb-6 grid w-full justify-items-center text-2xl font-bold"> Relatórios de Vendas </h1>
    <div class="mt-6 flex flex-col rounded-t-lg border-2 border-black">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
            <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                <i class="mx-2 text-xl fa fa-history"> </i>
                <span class="text-xl font-bold">A pagar</span>
            </div>
            <div class="overflow-auto" x-show="open" x-transition>
                <x-input class="my-2" placeholder="Pesquisar" wire:model.live="search"/>
                <table class="w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th scope="col">#</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Venda</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data</th>
                        <th class="" scope="col">Total:</th>
                        <th class="border-r" scope="col">R$ {{ $total }}</th>
                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach ($unconfirmedSale as $sale)
                        <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                            <td class="whitespace-nowrap px-2 py-4">{{ $sale->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ number_format($sale->cost,2) }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ number_format($sale->price,2) }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $sale->customer_name }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                {{ Carbon::parse($sale->created_at)->format('d/m/y') }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button class="w-full" info label="Detalhes"
                                          wire:click="modalSale({{ $sale->id }})"/>
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button class="w-full" positive label="Confirmar"
                                          wire:click="confirmDialog({{ $sale->id }})"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: true }">
            <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                <i class="mx-2 text-xl fa fa-check"> </i>
                <span class="text-xl font-bold">Pago</span>
            </div>
            <div class="overflow-auto" x-show="open" x-transition>
                <table class="w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th scope="col">#</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Venda</th>
                        <th scope="col">Lucro</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data</th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach ($sales as $sale)
                        <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                            <td class="whitespace-nowrap px-2 py-4">{{ $sale->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ number_format($sale->cost ,2)}}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{number_format( $sale->price,2) }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ number_format($sale->price - $sale->cost,2) }}
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $sale->customer_name }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                {{ Carbon::parse($sale->created_at)->format('d/m/y     ') }}</td>

                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button class="w-full" info label="Detalhes"
                                          wire:click="modalSale({{ $sale->id }})"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $sales->links() }}
            </div>
        </div>
    </div>


    <x-modal.card title="Detalhes da venda" blur wire:model.defer="modal" z-index="z-[1136]">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <x-input class="text-black dark:text-white" label="ID" wire:model="sale_detail.id" disabled/>
            <x-input class="text-black dark:text-white" label="Data" wire:model="sale_detail.created_at" disabled/>
            <x-input class="text-black dark:text-white" label="Cliente" wire:model="sale_detail.customer_name"
                     disabled/>
            <x-input class="text-black dark:text-white" label="Forma de pagamento"
                     wire:model="sale_detail.payment_method" disabled/>
            <x-input class="text-black dark:text-white" label="Custo" wire:model="sale_detail.cost" disabled/>
            <x-input class="text-black dark:text-white" label="Desconto" wire:model="sale_detail.discount" disabled/>
            <x-input class="text-black dark:text-white" label="Venda" wire:model="sale_detail.price" disabled/>
            <x-input class="text-black dark:text-white" label="Lucro" wire:model="sale_detail.profit" disabled/>

            <div
                class="mt-5 flex h-auto w-auto min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] dark:bg-gray-700 md:col-span-2">
                <div class="flex-1 p-2">
                    <ul class="grid gap-4 w-[100%]">
                        @foreach ($products as $product)
                            <li
                                class="flex min-w-fit justify-between rounded-lg bg-white shadow-lg h-18 dark:bg-gray-900">
                                <div class="p-2">
                                    <div>
                                        <span>{{ $product->product_name }}</span>
                                        <span>({{ $product->weight }})</span>
                                    </div>
                                    <div>
                                        <span>{{ $product->product_brand }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex w-8 min-w-fit items-center justify-center rounded-r-lg bg-gray-600 text-white">
                                    <span>{{ $product->amount }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div>
                    <x-button red label="Cancelar" wire:click="cancelDialog({{ $sale_detail['id'] }})"/>
                </div>
                <div class="flex gap-4">
                    <x-button info label="Recibo" href="{{ route('invoice', $sale_detail['id']) }}"/>
                    <x-button indigo label="Fechar" x-on:click="close"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>

</div>
