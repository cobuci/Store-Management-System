@section('title', 'Lista de Compras')
<div class="flex flex-col">

    <h1 class="grid justify-items-center font-bold text-2xl mb-6"> Lista de Compras</h1>
    <div
        class="flex flex-wrap bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto max-w-2xl min-w-min items-center justify-center drop-shadow-xl z-1">
        <x-notifications position="top-center"/>
        <div class="flex-1">
            <x-input class="" icon="shopping-bag" label="Produto" placeholder="Produto" name="product"
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
            <div class="grid ">
                <x-button class="my-4" icon="check" squared positive label="Adicionar" wire:click="store"/>
                <div class=" my-4 font-bold">Total: R$ {{ $total }}</div>
            </div>
        </div>

        <div class="flex p-2">

            <ul class="grid w-[100%] gap-4 sm:grid-cols-1 md:grid-cols-2">

                @foreach ($list as $item)
                    <li class="grid-span-1 h-18 min-w-fit  bg-white dark:bg-gray-900 rounded-lg p-3 shadow-lg"
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
