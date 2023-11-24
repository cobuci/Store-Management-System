<div class="flex flex-col w-[100%] items-center">

    <h1 class="grid justify-items-center font-bold text-2xl mb-6 "> Consultar CF-e </h1>

    <div
        class="flex flex-wrap bg-white/[.80] rounded-lg mb-6 dark:bg-gray-700 px-6 py-6 h-auto w-full min-w-min items-center justify-center drop-shadow-xl z-1">

        <div class="flex-1 md:justify-between md:flex gap-4">
            <x-input icon="key" placeholder="Digite a chave do cupom fiscal" wire:model='receiptKey' />
            <x-input class="mt-4 md:mt-0" icon="document" placeholder="Descrição" wire:model='receiptName' />
            <x-button class="h-1/2 m-auto mt-4 md:mt-0 rounded-lg" icon="check" squared positive label="Adicionar"
                wire:click='newReceipt' />
        </div>
    </div>

    @foreach ($receipts as $receipt)
        <div
            class="bg-white/[.80] md:flex justify-between rounded-lg mb-2 dark:bg-gray-700 px-6 py-6 h-auto w-full items-center drop-shadow-xl z-1">
            <div>
                <p> <span class="font-bold">Descrição: </span> {{ $receipt->name }} </p>
                <p class="break-words "><span class="font-bold">Chave CF-e:</span> {{ $receipt->key }} </p>
                <p> <span class="font-bold">Data de entrada:</span> {{ $receipt->created_at }} </p>
            </div>
            <x-button class="mt-4 md:mt-0 rounded-lg" icon="play" squared primary label="Verificar"
                wire:click="showReceipt({{ $receipt->id }})" />
        </div>
    @endforeach

</div>
