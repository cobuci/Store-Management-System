@section('title', 'Adicionar Produto')
<div class="flex flex-col w-full items-center">

    <h1 class="grid justify-items-center font-bold text-2xl mb-6">Adicionar Produto </h1>
    <div
        class="flex flex-wrap bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-full max-w-2xl min-w-min items-center justify-center drop-shadow-xl z-1">

        <div class="flex-1">
            <x-select
                label="Produto"
                placeholder="Selecione o produto"
                name="product"
                wire:model="product_id"
                required
            >
                @foreach ($products as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->name}} ({{$product->weight}}) - {{$product->brand}}"
                                     description="Estoque: {{$product->amount}} "/>
                @endforeach
            </x-select>

            <x-inputs.number label="Quantidade" name="amount" wire:model="amount" wire:change.live="calculateCost"/>
            <x-datetime-picker
                label="Validade"
                placeholder="Data de validade"
                display-format="DD-MM-YYYY"
                without-time="true"
                wire:model="expiration_date"
            />
            <div class="my-12">
                <x-inputs.currency label="Custo Unitario" prefix="R$" thousands="." decimal="," wire:model="cost"
                                   wire:change.live="calculateCost"/>
                <x-inputs.currency label="Custo Total" prefix="R$" thousands="." decimal="," wire:model="totalCost"
                                   wire:change.live="calculateUnitCost"/>

            </div>
            <x-inputs.currency label="Preço de Venda" prefix="R$" thousands="." decimal="," wire:model="price"
                               wire:change="calculateProfit"/>
            <x-inputs.currency label="Lucro" prefix="R$" thousands="." decimal="," wire:model="profit" disabled
                               class="mb-6"/>

            <x-datetime-picker
                label="Vencimento da fatura"
                placeholder="Dia do vencimento da fatura"
                display-format="DD-MM-YYYY"
                without-time="true"
                wire:model="expiration_purchase"
            />
            <x-button class="w-full my-4" icon="check" squared positive label="Adicionar" wire:click="addProduct"/>


        </div>

    </div>
</div>
