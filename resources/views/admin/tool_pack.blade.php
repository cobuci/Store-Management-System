@section('title', 'Fardo (abrir / fechar)')
<div class="flex h-full w-full flex-col items-center gap-4">
    <x-notifications position="top-center" z-index="z-[1036]"/>

    <div class="w-full min-w-fit max-w-2xl rounded-lg p-6 bg-white/[0.8] dark:bg-gray-700">
        <div class="flex justify-center text-xl">
            <span> Abrir Fardo</span>
        </div>
        <div>
            <x-select label="Fardo"
                      placeholder="Selecione o fardo para abrir"
                      name="pack"
                      wire:model="pack.id">
                @foreach ($packs as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->amount}} - {{$product->name}} ({{$product->weight}})"
                                     description="{{$product->brand}}"/>
                @endforeach
            </x-select>
            <x-inputs.number label="Quantidade" name="amount" wire:model="pack.amount"/>
            <x-select label="Produto"
                      placeholder="Selecione o produto destino"
                      name="product"
                      wire:model="product.id">
                @foreach ($products as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->amount}} - {{$product->name}} ({{$product->weight}})"
                                     description="{{$product->brand}}"/>
                @endforeach
            </x-select>
            <x-inputs.number label="Quantidade" name="amount" wire:model="product.amount"/>
            <x-button class="my-4 w-full rounded-lg" icon="check" squared positive label="Abrir" wire:click="openPack"/>
        </div>

    </div>


    <div class="w-full min-w-fit max-w-2xl rounded-lg p-6 bg-white/[0.8] dark:bg-gray-700">
        <div class="flex justify-center text-xl">
            <span> Fechar Fardo</span>
        </div>
        <div>
            <x-select label="Produto"
                      placeholder="Selecione o produto para colocar no fardo"
                      name="product"
                      wire:model="productClose.id">
                @foreach ($products as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->amount}} - {{$product->name}} ({{$product->weight}})"
                                     description="{{$product->brand}}"/>
                @endforeach
            </x-select>
            <x-inputs.number label="Quantidade" name="amount" wire:model="productClose.amount"/>
            <x-select label="Fardo"
                      placeholder="Selecione o fardo destino"
                      name="pack"
                      wire:model="packClose.id">
                @foreach ($packs as $product)
                    <x-select.option value="{{$product->id}}"
                                     label=" {{$product->amount}} - {{$product->name}} ({{$product->weight}})"
                                     description="{{$product->brand}}"/>
                @endforeach
            </x-select>
            <x-inputs.number label="Quantidade" name="amount" wire:model="packClose.amount"/>
            <x-button class="my-4 w-full rounded-lg" icon="check" squared positive label="Fechar"
                      wire:click="closePack"/>
        </div>

    </div>

</div>
