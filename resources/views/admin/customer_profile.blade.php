@php use Carbon\Carbon; @endphp
@section('title', 'Perfil do cliente')
<div class="w-full h-full">
    <x-notifications position="top-center" z-index="z-[1400]"/>
    <x-button class="w-auto mb-5" icon="arrow-left" squared blue label="Voltar" href="{{ route('admin.customer') }}"/>
    <div class="flex flex-wrap gap-5">
        <div class="dark:bg-gray-600 bg-white h-full w-auto min-w-fit p-4 rounded-lg">

            <div class="flex justify-center items-center mb-5 h-auto w-full">
                <span class="font-bold text-xl">{{ $customer['name'] }} </span>
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
            <x-button class="w-full mt-5" icon="check" squared positive label="Salvar" wire:click="update"/>
            <x-button class="w-full mt-5" icon="trash" squared red label="Excluir" wire:click="deleteModal"/>


        </div>

        <div class="flex flex-col flex-1 w-full h-full">
            <div class="grid md:grid-cols-3 gap-4 mb-4 pt-0 flex-wrap ">
                <div class="dark:bg-gray-600 bg-white rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="font-bold ">Valor Devido</span>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div>
                        R$ {{ $customer['debits'] }}
                    </div>
                </div>
                <div class="dark:bg-gray-600 bg-white rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="font-bold ">Total gasto (PAGO)</span>
                        <x-icon name="cash" class="w-auto h-6"/>
                    </div>
                    <div>
                        R$ {{ $customer['spent'] }}
                    </div>
                </div>
                <div class="dark:bg-gray-600 bg-white rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="font-bold ">Águas Compradas</span>
                        <i class="fas fa-droplet "></i>
                    </div>
                    <div>
                        {{ $customer['water'] }}
                    </div>
                </div>
            </div>
            <div class=" w-full overflow-auto ">
                <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900 " x-data="{ open: true }">
                    <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                        <i class="fa fa-history text-xl mx-2"> </i>
                        <span class="font-bold text-xl">A pagar</span>
                    </div>
                    <div class="overflow-auto" x-show="open" x-transition>
                        <table class="w-full">
                            <thead class="border-b border-1">
                            <tr class="bg-white/[0.1]">
                                <th class="border-r" scope="col">#</th>
                                <th class="border-r" scope="col">Custo</th>
                                <th class="border-r" scope="col">Venda</th>
                                <th class="border-r" scope="col">Data</th>
                            </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700">
                            @foreach ($unconfirmedSale as $sale)
                                <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                    <td class="whitespace-nowrap px-2 py-4 border-r">{{ $sale->id }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->cost }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->price }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">
                                        {{ Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 ">
                                        <x-button class="w-full" info label="Detalhes"
                                                  wire:click="modalSale({{ $sale->id }})"/>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r ">
                                        <x-button class="w-full" positive label="Confirmar"
                                                  wire:click="confirmSale({{ $sale->id }})"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=" bg-white/[0.8] dark:bg-gray-900  min-w-fit " x-data="{ open: false }">
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
                                <th class="border-r" scope="col">Data</th>
                            </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700">
                            @foreach ($confirmedSale as $sale)
                                <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                    <td class="whitespace-nowrap px-2 py-4 border-r">{{ $sale->id }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->cost }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">R$ {{ $sale->price }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 border-r">
                                        {{ Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>
                                    <td class="whitespace-nowrap px-2 py-4 ">
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

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-input label="ID" wire:model="sale_detail.id" disabled/>
            <x-input label="Data" wire:model="sale_detail.created_at" disabled/>
            <x-input label="Cliente" wire:model="sale_detail.customer_name" disabled/>
            <x-input label="Forma de pagamento" wire:model="sale_detail.payment_method" disabled/>
            <x-input label="Custo" wire:model="sale_detail.cost" disabled/>
            <x-input label="Desconto" wire:model="sale_detail.discount" disabled/>
            <x-input label="Venda" wire:model="sale_detail.price" disabled/>
            <x-input label="Lucro" wire:model="sale_detail.profit" disabled/>

            <div
                class="md:col-span-2 flex flex-wrap bg-white/[.80] mt-5 rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto min-w-min items-center justify-center drop-shadow-xl">
                <div class="flex-1 p-2">
                    <ul class="grid w-[100%] gap-4">
                        @foreach ($products as $product)
                            <li
                                class="flex justify-between h-18 min-w-fit bg-white dark:bg-gray-900 rounded-lg shadow-lg">
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
                                    class="bg-gray-600 text-white rounded-r-lg  w-8 min-w-fit flex items-center justify-center ">
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
                <div class="flex gap-4 ">
                    <x-button info label="Recibo" href="{{ route('invoice', $sale_detail['id']) }}"/>
                    <x-button indigo label="Fechar" x-on:click="close"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>

</div>
