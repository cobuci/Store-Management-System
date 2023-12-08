<div>
    <x-button info label="Editar" wire:click="openModal" />

    @if ($cardModal)
        <x-modal.card title="Editar o produto" blur wire:model.defer="cardModal" z-index="z-[1136]">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="col-span-1 sm:col-span-2">
                    <x-input label="ID" wire:model="product.id" name="name" disabled />
                </div>
                <x-input label="Produto" placeholder="Nome do produto" wire:model="product.name" />
                <x-select label="Categoria (*)" :options="$categories" option-label="name" option-value="id" name="categoria"
                    wire:model="product.category_id" placeholder="Selecione a categoria" />


                <div class="col-span-1 sm:col-span-2">

                    <x-input icon="briefcase" label="Marca" placeholder="Marca" name="brand"
                        wire:model="product.brand" />

                </div>

                <x-input icon="scale" label="Unidade peso (*)" placeholder="Peso" name="weight"
                    wire:model="product.weight" />
                <x-select label="Tipo peso" placeholder="Selecione o tipo do peso" :options="[
                    ['name' => 'Mililitros', 'value' => 'ml'],
                    ['name' => 'Litros', 'value' => 'l'],
                    ['name' => 'Gramas', 'value' => 'g'],
                    ['name' => 'Kilogramas', 'value' => 'kg'],
                    ['name' => 'Unidade', 'value' => 'un'],
                ]" option-label="name"
                    wire:model="product.weight_type" option-value="value" />
                <x-inputs.number label="Quantidade" name="amount" wire:model="product.amount" />
                <x-datetime-picker label="Validade" placeholder="Data de validade" display-format="DD-MM-YYYY"
                    without-time="true" wire:model="product.expiration_date" />
                <x-inputs.currency label="Custo" prefix="R$" thousands="." decimal=","
                    wire:model="product.cost" />
                <x-inputs.currency label="Preço de Venda" prefix="R$" thousands="." decimal=","
                    wire:model="product.sale" />

            </div>

            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <div></div>
                    <div class="flex">
                        <x-button flat label="Cancelar" wire:click="$set('cardModal',false)" />
                        <x-button primary label="Salvar" wire:click="productEdit" />
                    </div>
                </div>
            </x-slot>
        </x-modal.card>
    @endif
</div>
