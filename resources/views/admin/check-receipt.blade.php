<div class="flex flex-col items-center w-[100%]">

    <h1 class="mb-6 grid justify-items-center text-2xl font-bold"> Consultar CF-e </h1>

    <div
        class="mb-6 flex h-auto w-full min-w-min flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700">

        <div class="flex-1 gap-4 md:flex md:justify-between">
            <x-input icon="key" placeholder="Digite a chave do cupom fiscal" wire:model='receiptKey'/>
            <x-input class="mt-4 md:mt-0" icon="document" placeholder="Descrição" wire:model='receiptName'/>
            <x-button class="m-auto mt-4 h-1/2 rounded-lg md:mt-0" icon="check" squared positive label="Adicionar"
                      wire:loading.attr="disabled"
                      wire:click='newReceipt'/>
        </div>
    </div>

    @foreach ($receipts as $receipt)
        <div
            class="mb-2 h-auto w-full items-center justify-between rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700 md:flex">
            <div>
                <p><span class="font-bold">Descrição: </span> {{ $receipt->name }} </p>
                <p class="break-words"><span class="font-bold">Chave CF-e:</span> {{ $receipt->key }} </p>
                <p><span class="font-bold">Data de entrada:</span> {{ $receipt->created_at }} </p>
            </div>
            <x-button class="mt-4 rounded-lg md:mt-0" icon="play" squared primary label="Verificar"
                      wire:click="showReceipt({{ $receipt->id }})"/>
        </div>
    @endforeach

</div>
