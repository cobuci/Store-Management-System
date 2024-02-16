<div class="bg-gray-700 p-6 rounded-lg w-full mb-4 md:flex justify-between">
    <div>
        <p><strong>Cliente: </strong>{{ $sale['customer'] }} </p>
        <p><strong>Data da Venda:</strong> {{ $sale['date'] }} </p>
        <p><strong>Ultima atualização: </strong> {{ $sale['updated'] }} </p>
    </div>
    <div class="self-center mt-4 md:mt-0">
        <button class="p-4 bg-gray-800 font-bold rounded-lg hover:bg-gray-900" wire:click="openModal">Detalhes</button>
    </div>


    <x-modal.card title="Detalhes da venda" blur wire:model.defer="cardModal" z-index="z-[1136]">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input class="text-black dark:text-white" label="Cliente" wire:model="sale.customer" disabled />

            <x-input class="text-black dark:text-white" label="Data" wire:model="sale.date" disabled />

            <div
                class="mt-5 flex h-auto w-auto min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] dark:bg-gray-700 md:col-span-2">
                <div class="flex-1 p-2">
                    <ul class="grid gap-4 w-[100%]">
                        @foreach ($sale['items'] as $product)
                            <li
                                class="flex min-w-fit justify-between rounded-lg bg-white shadow-lg h-18 dark:bg-gray-900">
                                <div class="p-2">
                                    <div>
                                        <span>{{ $product['name'] }}</span>

                                        <span>({{ $product['weight'] }})</span>
                                    </div>
                                    <div>
                                        <span>{{ $product['brand'] }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex w-8 min-w-fit items-center justify-center rounded-r-lg bg-gray-600 text-white">
                                    <span>{{ $product['amount'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button green label="Finalizar Venda" wire:click="continueOrder"/>
            </div>
        </x-slot>
    </x-modal.card>

</div>
