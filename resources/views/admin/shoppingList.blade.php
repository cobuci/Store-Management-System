@section('title', 'Lista de Compras')

<div class="flex flex-wrap bg-white/[.80] px-6 py-6 h-auto w-auto items-center justify-center drop-shadow-xl">
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
        <x-button class="float-right my-4" squared positive label="Adicionar" wire:click="store"/>
    </div>

    <div class="flex w-[100%] p-2">

        <ul>
            @foreach ($list as $item)
                <li class="bg-white mb-2 shadow-lg" wire:click='delete({{$item->id}})'>
                    {{ $item->amount }}x {{ $item->product }} - R$ {{ $item->cost }} (un.)
                    - {{$item->final_price}}(+{{$item->fee}}%) - Total: R$ {{$item->final_price*$item->amount  }}
                </li>
            @endforeach
            <div class="float-right">Total: R$ {{ $total }}</div>
        </ul>

    </div>

</div>


