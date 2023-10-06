@section('title', 'Cadastrar Produto')
<div class="flex flex-col w-[100%] items-center">

    <h1 class="grid justify-items-center font-bold text-2xl mb-6"> Cadastrar Produto </h1>
    <div
        class="flex flex-wrap bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-full min-w-min max-w-3xl items-center justify-center drop-shadow-xl z-1">

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
            <x-input icon="scale" label="Quantidade (peso) (*)" placeholder="Quantidade" name="weight" wire:model="weight"/>
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
            <x-button class="my-4 w-full" icon="check" squared positive label="Cadastrar" wire:click="store"/>

        </div>

    </div>
</div>
