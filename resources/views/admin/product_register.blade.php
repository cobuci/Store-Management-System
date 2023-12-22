@section('title', 'Cadastrar Produto')
<div class="flex flex-col items-center w-[100%]">

    <h1 class="mb-6 grid justify-items-center text-2xl font-bold"> Cadastrar Produto </h1>
    <div
        class="flex h-auto w-full min-w-min max-w-3xl flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700">

        <div class="flex-1">
            <x-select
                label="Categoria (*)"
                :options="$categories"
                option-label="name"
                option-value="id"
                wire:model="category_id"
                name="categoria"
                placeholder="Selecione a categoria"
            />

            <x-input icon="shopping-bag" label="Nome do Produto (*)" placeholder="Produto" name="product"
                     wire:model="name"/>

            <x-input icon="briefcase" label="Marca" placeholder="Marca" name="brand" wire:model="brand"/>
            <x-input icon="scale" label="Quantidade (peso) (*)" placeholder="Quantidade" name="weight"
                     wire:model="weight"/>
            <x-select label="Unidade Medida" placeholder="Selecione a unidade de medida"
                      :options="[
                        ['name' => 'Mililitros', 'value'=>'ml'],
                        ['name' => 'Litros', 'value'=>'l'],
                        ['name' => 'Gramas', 'value'=>'g'],
                        ['name' => 'Kilogramas', 'value'=>'kg'],
                        ['name' => 'Unidade', 'value'=>'un'],
                 ]"
                      option-label="name"
                      wire:model="weight_type"
                      option-value="value"/>
            <x-input label="UPC" name="upc" icon="qrcode" placeholder="Digite o código de barras do produto"
                     wire:model="upc"/>
            <x-button class="my-4 w-full" icon="check" squared positive label="Cadastrar" wire:click="store"/>

        </div>

    </div>
</div>
