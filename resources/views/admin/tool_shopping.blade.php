@section('title', 'Lista de Compras')
<div class="flex flex-col">

    <h1 class="mb-6 grid justify-items-center text-2xl font-bold"> Lista de Compras</h1>
    <div
        class="flex h-auto w-auto min-w-min max-w-2xl flex-wrap items-center justify-center rounded-lg px-6 py-6 drop-shadow-xl bg-white/[.80] z-1 dark:bg-gray-700">
        <x-notifications position="top-center" z-index="z-[1036]"/>
        <div class="flex-1">
            <x-input icon="shopping-bag" label="Produto" placeholder="Produto" name="product"
                     wire:model="product"/>
            <x-inputs.number label="Quantidade" name="amount" wire:model="amount"/>
            <x-inputs.currency label="Custo" prefix="R$" thousands="." decimal="," wire:model="cost"/>
            <x-select label="Taxa" placeholder="Selecione a taxa"
                      :options="[
                            ['name' => '1%',  'id' => 1 , 'fee'=>1],
                            ['name' => '3%', 'id' => 2, 'fee'=>3],
                            ['name' => '5%',   'id' => 3, 'fee'=>5],
                            ['name' => '6%',    'id' => 4, 'fee'=>6],
                            ['name' => '10%',    'id' => 5, 'fee'=>10],
                            ['name' => '15%',   'id' => 6, 'fee'=>15],
                        ]"
                      option-label="name"
                      wire:model="fee"
                      option-value="fee"/>
            <div class="grid">
                <x-button class="my-4" icon="check" squared positive label="Adicionar" wire:click="store"/>
                <div class="my-4 font-bold">Total: R$ {{ $total }}</div>
            </div>
        </div>

        <div class="flex p-2">
            <ul class="grid gap-4 w-[100%] sm:grid-cols-1 md:grid-cols-2">

                @foreach ($list as $item)
                    <li class="min-w-fit cursor-pointer rounded-lg bg-white p-3 shadow-lg grid-span-1 h-18 dark:bg-gray-900"
                        wire:click="deleteDialog({{$item->id}})">
                        <div>
                            <span>{{ $item->amount }}x</span>
                            <span>{{ $item->product }} </span>
                        </div>
                        <div class="flex flex-nowrap justify-between">
                            <span>R$ {{ $item->cost }} (un.) - {{$item->final_price}}(+{{$item->fee}}%)</span>
                            <span>Total: R$ {{ $item->final_price * $item->amount }}</span>
                        </div>
                    </li>
                @endforeach

            </ul>

        </div>

    </div>

</div>
