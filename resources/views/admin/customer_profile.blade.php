@php use Carbon\Carbon; @endphp
@section('title', 'Perfil do cliente')
<div class="h-full w-full select-none">
    <x-notifications position="top-center" z-index="z-[1400]"/>
    <x-button class="mb-5 w-auto" icon="arrow-left" squared blue label="Voltar" href="{{ route('admin.customer') }}"/>
    <div class="flex flex-wrap gap-5">
        <div class="h-full w-full min-w-fit rounded-lg bg-white p-4 dark:bg-gray-600 md:w-auto">

            <div class="mb-5 flex h-auto w-full items-center justify-center">
                <span class="text-xl font-bold">{{ $customer['name'] }} </span>
            </div>
            <x-input label="ID" wire:model="customer.id" disabled/>
            <x-input label="Nome" wire:model="customer.name"/>
            <x-select label="Sexo" placeholder="Selecione o sexo"
                      :options="[['name' => 'Masculino', 'value' => 'Masculino'], ['name' => 'Feminino', 'value' => 'Feminino']]"
                      option-label="name"
                      wire:model="customer.gender" option-value="value"/>
            <x-input label="Telefone" wire:model="customer.phone"/>
            <x-input label="Email" wire:model="customer.email"/>
            <x-input label="CEP" wire:model="customer.zipcode"/>
            <x-input label="Endereço" wire:model="customer.street"/>
            <x-input label="Número" wire:model="customer.number"/>
            <x-input label="Bairro" wire:model="customer.district"/>
            <x-button class="mt-5 w-full" icon="check" squared positive label="Salvar" wire:click="update"/>
            <x-button class="mt-5 w-full" icon="trash" squared red label="Excluir" wire:click="deleteModal"/>


        </div>

        <div class="flex h-full w-full flex-1 flex-col">
            <div class="mb-4 grid flex-wrap gap-4 pt-0 md:grid-cols-3">
                <div class="rounded-lg bg-white p-4 dark:bg-gray-600">
                    <div class="flex justify-between">
                        <span class="font-bold">Valor Devido</span>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div>
                        R$ {{ $customer['debits'] }}
                    </div>
                </div>
                <div class="rounded-lg bg-white p-4 dark:bg-gray-600">
                    <div class="flex justify-between">
                        <span class="font-bold">Total gasto (PAGO)</span>
                        <x-icon name="cash" class="h-6 w-auto"/>
                    </div>
                    <div>
                        R$ {{ $customer['spent'] }}
                    </div>
                </div>
            </div>
            <div class="w-full overflow-auto">
                <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900" x-data="{ open: true }">
                    <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                        <i class="mx-2 text-xl fa fa-history"> </i>
                        <span class="text-xl font-bold">A pagar</span>
                    </div>
                    <div class="overflow-auto" x-show="open" x-transition>
                        <table class="w-full">
                            <thead class="border-b border-1">
                            <tr class="bg-whit
                                <th scope=" col
                            ">#</th>
                            <th scope="col">Custo</th>
                            <th scope="col">Venda</th>
                            <th scope="col">Data</th>
                            </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700">
                            @foreach ($unconfirmedSale as $sale)
                                <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                                    <td class="whitespace-nowrap px-2 py-4">{{ $sale->id }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">R$ {{ $sale->cost }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">R$ {{ $sale->price }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">
                                        {{ Carbon::parse($sale->created_at)->format('d/m/y') }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">
                                        <x-button class="w-full" info label="Detalhes"
                                                  wire:click="modalSale({{ $sale->id }})"/>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4">
                                        <x-button class="w-full" positive label="Confirmar"
                                                  wire:click="confirmSale({{ $sale->id }})"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="min-w-fit bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
                    <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                        <i class="mx-2 text-xl fa fa-check"> </i>
                        <span class="text-xl font-bold">Pago</span>
                    </div>
                    <div class="w-full" x-show="open" x-transition>
                        <table class="w-full min-w-full">
                            <thead class="border-b border-1">
                            <tr class="bg-white/[0.1]">
                                <th scope="col">#</th>
                                <th scope="col">Custo</th>
                                <th scope="col">Venda</th>
                                <th scope="col">Data</th>
                            </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700">
                            @foreach ($confirmedSale as $sale)
                                <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                                    <td class="whitespace-nowrap px-2 py-4">{{ $sale->id }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">R$ {{ $sale->cost }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">R$ {{ $sale->price }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">
                                        {{ Carbon::parse($sale->created_at)->format('d/m/y') }}</td>
                                    <td class="whitespace-nowrap px-2 py-4">
                                        <x-button class="w-full" info label="Detalhes"
                                                  wire:click="modalSale({{ $sale->id }})"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
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
