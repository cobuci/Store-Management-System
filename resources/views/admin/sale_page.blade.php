@section('title', 'Sale Page')
<div class="flex flex-col  w-full md:max-w-3xl">
    <h1 class="grid justify-items-center font-bold text-2xl mb-6">Vender</h1>
    <x-notifications position="top-center" z-index="z-[1035]"  />
    <div
        class="flex flex-wrap bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto min-w-min items-center justify-center drop-shadow-xl z-[100]">
        <div class="flex-1">

            <x-select
                label="Categoria"
                placeholder="Selecione a categoria"
                option-label="name"
                option-value="id"
                :options="$categories"
                wire:model.live="category"
                />
            <x-select
                label="Produtos"
                placeholder="Selecione o produto"
                name="product"
                wire:model.live="product"
            >
                @foreach ($products as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->name}} ({{$product->weight}}) - {{$product->brand}}"
                                     description="Estoque: {{$product->amount}} "/>
                @endforeach
            </x-select>

            <x-inputs.number label="Quantidade" name="amount" wire:model="amount"/>
            <x-button class="w-full my-4" icon="check" squared positive label="Adicionar" wire:click="addProduct"/>


        </div>
    </div>
    <div class="grid md:grid-cols-3">
        {{--    // Lista produtos--}}
        <div
            class="md:col-span-2 flex flex-wrap bg-white/[.80] mt-5 rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto min-w-min items-center justify-center drop-shadow-xl">
            <div class="flex-1 p-2">
                <ul class="grid w-[100%] gap-4">
                    @foreach ($list as $key=>$item)
                        <li class="flex justify-between h-18 min-w-fit cursor-pointer  bg-white dark:bg-gray-900 rounded-lg shadow-lg"
                            wire:click="removeProduct({{$key}})">

                            <div class="p-2">
                                <div>
                                    <span>{{$item['name']}}</span>
                                    <span>({{$item['weight']}})</span>

                                </div>
                                <div><span>{{$item['brand']}}</span>

                                </div>
                            </div>
                            <div
                                class="bg-gray-600 text-white rounded-r-lg  w-8 min-w-fit flex items-center justify-center ">
                                <span>{{$item['amount']}}</span>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{--    // Finalizar Venda --}}
        <div
            class="flex flex-wrap bg-white/[.80] mt-5 rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto min-w-min items-center justify-center drop-shadow-xl">
            <div class="flex-1 p-2">
                <x-inputs.currency label="Desconto" prefix="R$" thousands="." decimal="," wire:model="discount"
                                   wire:change.live="calculateTotal"/>
                <x-inputs.currency label="Valor Total" prefix="R$" thousands="." decimal="," wire:model="finalPrice"
                                   class="cursor-not-allowed" disabled/>
                <x-select
                    label="Forma de pagamento"
                    :options="[
                    ['name' => 'Dinheiro',  'id' => 1],
                    ['name' => 'PIX', 'id' => 2],
                    ['name' => 'Credito',   'id' => 3],
                    ['name' => 'Debito',    'id' => 4],
                    ['name' => 'Outro',    'id' => 5],
                ]"
                    option-label="name"
                    option-value="name"
                    wire:model="payment_method"
                    name="payment_method"
                />
                <x-select
                    label="Bonificação"
                    :options="[
                        ['name' => 'Não',  'value' => 0],
                        ['name' => 'Sim', 'value' => 1],
                    ]"
                    option-label="name"
                    option-value="value"
                    wire:model.live="bonus"
                    name="bonus"
                />
                <x-select
                    label="Cliente"
                    :options="$customers"
                    option-label="name"
                    option-value="id"
                    wire:model="customer"
                    name="customer"
                />
                <x-button class="w-full mt-4 " positive label="Vender" wire:click="saveSale" wire:loading.attr="disabled"/>
            </div>
        </div>
    </div>
</div>
