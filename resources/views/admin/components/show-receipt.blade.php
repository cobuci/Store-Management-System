<div class="w-full h-full select-none">
    <x-button class="w-auto mb-5 rounded-lg" icon="arrow-left" squared blue label="Voltar"
        href="{{ route('admin.tool.check-receipt') }}" />

    @foreach ($products as $product)
        <div
            class=" {{ $product->active ? 'bg-white/[.80]  dark:bg-gray-700' : 'bg-primary-500/[.5]' }}  md:flex justify-between rounded-lg mb-2 px-6 py-6 h-auto w-full items-center drop-shadow-xl z-1">

            <p><span class="font-bold"> </span> {{ $product->name }}</p>
            <p><span class="font-bold"> Custo:</span> R${{ $product->price }}</p>
            <p><span class="font-bold"> Quantidade: </span>{{ $product->amount }}</p>
            <p><span class="font-bold"> Total:</span> R${{ $product->total }}</p>

            <x-button class="mt-4 md:mt-0 rounded-lg" icon="check" squared green wire:click="productActive({{$product->id}})" />

        </div>
    @endforeach

</div>
