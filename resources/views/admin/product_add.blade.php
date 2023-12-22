@section('title', 'Adicionar Produto')
<div class="flex w-full flex-col items-center">

    <h1 class="mb-6 grid justify-items-center text-2xl font-bold">Adicionar Produto </h1>
    <div
        class="flex h-auto w-full min-w-min max-w-2xl flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700">

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
                label="Produto"
                placeholder="Selecione o produto"
                name="product"
                wire:model.live="product_id"
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
            <x-button class="my-4 w-full" icon="check" squared positive label="Adicionar" wire:click="addProduct"/>


        </div>

    </div>
</div>
