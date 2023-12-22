@section('title', 'Sale Page')
<div class="flex w-full flex-col md:max-w-3xl">
    <h1 class="mb-6 grid justify-items-center text-2xl font-bold">Vender</h1>
    <x-notifications position="top-center" z-index="z-[1035]"/>
    <div
        class="flex h-auto w-auto min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-[100] dark:bg-gray-700">
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
            <x-button class="my-4 w-full" icon="check" squared positive label="Adicionar" wire:click="addProduct"/>


        </div>
    </div>
    <div class="grid md:grid-cols-3">
        {{--    // Lista produtos--}}
        <div
            class="mt-5 flex h-auto w-auto min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] dark:bg-gray-700 md:col-span-2">
            <div class="flex-1 p-2">
                <ul class="grid gap-4 w-[100%]">
                    @foreach ($list as $key=>$item)
                        <li class="flex min-w-fit cursor-pointer justify-between rounded-lg bg-white shadow-lg h-18 dark:bg-gray-900"
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
                                class="flex w-8 min-w-fit items-center justify-center rounded-r-lg bg-gray-600 text-white">
                                <span>{{$item['amount']}}</span>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{--    // Finalizar Venda --}}
        <div
            class="mt-5 flex h-auto w-auto min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] dark:bg-gray-700">
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
                <x-button class="mt-4 w-full" positive label="Vender" wire:click="saveSale"
                          wire:loading.attr="disabled"/>
            </div>
        </div>
    </div>
</div>
