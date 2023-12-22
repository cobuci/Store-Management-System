@section('title', 'Cadastrar Cliente')
<div class="flex w-full flex-col items-center">

    <h1 class="mb-6 grid justify-items-center text-2xl font-bold"> Cadastrar Cliente</h1>
    <div
        class="flex h-auto w-full min-w-min max-w-2xl flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700">
        <x-notifications position="top-center"/>
        <div class="flex-1">
            <x-input icon="user" label="Nome" placeholder="Digite o nome do cliente" name="product"
                     wire:model="customer.name"/>
            @error('customer.name') <span class="text-red-500">{{ $message }}</span> @enderror

            <x-select label="Sexo" placeholder="Selecione o sexo"
                      :options="[
                            ['name' => 'Masculino', 'value'=>'Masculino'],
                            ['name' => 'Feminino', 'value'=>'Feminino'],
                      ]"
                      option-label="name"
                      wire:model="customer.gender"
                      option-value="value"/>
            <hr class="my-6">
            <x-input icon="phone" label="Telefone" placeholder="Telefone" name="phone"
                     wire:model.lazy="customer.phone"/>
            <x-input icon="mail" label="Email" placeholder="Email" name="email" wire:model="customer.email"/>
            @error('customer.email') <span class="text-red-500">{{ $message }}</span> @enderror
            <hr class="my-6">
            <x-input icon="location-marker" label="CEP" placeholder="CEP" name="zip" wire:model.lazy="zip_code"/>
            <x-input icon="map" label="Rua" placeholder="Digite a Rua" name="street"
                     wire:model="customer.street"/>
            <x-input icon="home" label="Número" placeholder="Digite o número" name="number"
                     wire:model="customer.number"/>
            <x-input icon="map" label="Bairro" placeholder="Digite o bairro" name="distric"
                     wire:model="customer.district"/>
            <x-button class="my-4 w-full" icon="check" squared positive label="Cadastrar" wire:click="save"/>
        </div>
    </div>


</div>
