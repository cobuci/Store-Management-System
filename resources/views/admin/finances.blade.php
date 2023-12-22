@php use Carbon\Carbon; @endphp
@section('title', 'Finanças')
<div class="h-full w-full max-w-4xl select-none">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    <div class="grid gap-4 text-white md:grid-cols-3">
        <div class="cursor-pointer rounded-lg bg-green-600 p-4 font-bold hover:bg-green-800"
             wire:click="showBalanceOptions">
            <div class="flex justify-between text-xl">
                <span>Saldo</span>
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <span class="text-3xl">R$ {{number_format($balance,2)}}</span>
            </div>
        </div>
        <div class="rounded-lg bg-blue-600 p-4 font-bold">

            <div class="flex justify-between text-xl">
                <span>A pagar</span>
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <span class="text-3xl">R$ {{number_format($value_unpaid_purchases,2)}}</span>
            </div>
        </div>
        <div class="rounded-lg bg-orange-600 p-4 font-bold">

            <div class="flex justify-between text-xl">
                <span class="">A receber</span>

                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <span class="text-3xl">R$ {{ number_format($due,2) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4 h-full w-full overflow-auto">
        <table class="my-2 w-full whitespace-nowrap rounded-md p-2 bg-white/[0.7] dark:bg-gray-500">
            <tr>
                <thead class="">
                <th>ID</th>
                <th>Valor</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Opções</th>
                </thead>
            </tr>
            <tbody class="my-2 rounded-md dark:bg-gray-600">

            @foreach($finances as $finance)
                <tr class="flex-1 cursor-default bg-white/[0.8] hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-900">

                    <td>
                        <x-badge full outline label=" #{{ $finance->id }}"/>
                    </td>
                    <td class="px-4">
                        @if($finance->type == 'wd' || $finance->type == 'rdm' || $finance->type == 'rev')
                            <x-badge lg full negative label=" R$ {{ number_format($finance->value,2) }}"/>
                        @else
                            <x-badge lg full positive label="R$ {{number_format( $finance->value,2) }}"/>
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
        <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2">
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


    <x-modal.card title="Resgatar saldo: R${{ $balance}}" blur wire:model.defer="modalBalanceRemove" z-index="z-[1330]">
        <div class="">
            <div>
                <x-button primary label="Zerar" wire:click="withdrawAll"/>
            </div>
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
