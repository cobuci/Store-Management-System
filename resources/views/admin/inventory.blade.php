@section('title', 'Estoque')
<div class="w-full select-none">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div
        class="flex flex-wrap w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border-2 border-black justify-between">
       <span class="flex flex-nowrap font-medium">
             Custo Total:  {{ $values['cost']}}
        </span>
        <span class="flex flex-nowrap font-medium">
            Venda Total:  {{ $values['sale']}}
       </span>
        <span class="flex flex-nowrap font-medium">
           Lucro Total:  {{ $values['profit']}}
       </span>

    </div>

    <livewire:components.show-products wire:loading.remove/>

</div>
