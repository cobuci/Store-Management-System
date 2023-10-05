@php use Carbon\Carbon; @endphp
@section('title', 'Finanças')
<div class="w-full h-full max-w-4xl">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    <div class="grid md:grid-cols-3 gap-4 text-white">
        <div class="bg-green-600 hover:bg-green-800 p-4 rounded-lg font-bold cursor-pointer" wire:click="showBalanceOptions">
            <div class="flex justify-between text-xl">
                <span>Saldo</span>
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <span class=" text-3xl">R$ {{$balance}}</span>
            </div>
        </div>
        <div class="bg-blue-600 p-4 rounded-lg font-bold">

            <div class="flex justify-between text-xl ">
                <span>A pagar</span>
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <span class=" text-3xl">R$ {{$value_unpaid_purchases}}</span>
            </div>
        </div>
        <div class="bg-orange-600 p-4 rounded-lg font-bold">

            <div class="flex justify-between text-xl ">
                <span class="">A receber</span>

                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <span class="text-3xl">R$ {{ $due }}</span>
            </div>
        </div>
    </div>

    <div class="w-full h-full mt-4 overflow-auto">
        <table class="w-full dark:bg-gray-500 bg-white/[0.7] my-2 whitespace-nowrap rounded-md p-2  ">
            <tr>
                <thead class="">
                <th>ID</th>
                <th>Valor</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Opções</th>
                </thead>
            </tr>
            <tbody class="dark:bg-gray-600 my-2 rounded-md">

            @foreach($finances as $finance)
                <tr class="dark:hover:bg-gray-900 dark:bg-gray-700 bg-white/[0.8] hover:bg-gray-200 flex-1 cursor-default">

                    <td>
                        <x-badge full outline label=" #{{ $finance->id }}"/>
                    </td>
                    <td class="px-4">
                        @if($finance->type == 'wd' || $finance->type == 'rdm' || $finance->type == 'rev')
                            <x-badge lg full negative label=" R$ {{ $finance->value }}"/>
                        @else
                            <x-badge lg full positive label="R$ {{ $finance->value }}"/>
                        @endif
                    </td>
                    <td>
                        <x-badge outline full lg zinc label="{{ $finance->description }}"/>
                    </td>
                    <td>
                        <x-badge outline full lg zinc label=" {{ Carbon::parse($finance->date)->format('d/m/y') }}"/>
                    </td>

                    @if($finance->type == 'rdm' || $finance->type == 'inv')
                        <td class="p-4">
                            <x-button red class="w-full" label="Cancelar" wire:click="dialogCancel({{ $finance->id }})"
                            />
                        </td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $finances->links() }}
    </div>

    <x-modal.card title="Balance Options" blur wire:model.defer="modalBalanceOptions" z-index="z-[1330]">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
            <x-button class="w-full" positive label="Adicionar" wire:click="showAddBalance"/>
            <x-button class="w-full" info label="Resgatar" wire:click="showRemoveBalance"/>
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>
                <div class="flex">
                    <x-button red label="Fechar" x-on:click="close"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>

    <x-modal.card title="Adicionar saldo" blur wire:model.defer="modalBalanceAdd" z-index="z-[1330]">
        <div class="">
            <x-inputs.currency label="Valor" prefix="R$" thousands="." decimal="," wire:model="value_balance_add"
            />

        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div>
                    <x-button red label="Fechar" x-on:click="close"/>
                </div>
                <div class="flex">
                    <x-button class="w-full" positive label="Adicionar" wire:click="addBalance"/>

                </div>
            </div>
        </x-slot>
    </x-modal.card>


    <x-modal.card title="Resgatar saldo" blur wire:model.defer="modalBalanceRemove" z-index="z-[1330]">
        <div class="">
            <x-inputs.currency label="Valor" prefix="R$" thousands="." decimal="," wire:model="value_balance_remove"
            />

        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div>
                    <x-button red label="Fechar" x-on:click="close"/>
                </div>
                <div class="flex">
                    <x-button class="w-full" positive label="Resgatar" wire:click="withdrawBalance"/>

                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
