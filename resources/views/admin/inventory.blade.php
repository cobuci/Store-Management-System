@section('title', 'Estoque')
<div class="w-full select-none">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div
        class="flex w-full min-w-fit flex-wrap justify-between rounded-lg border-2 border-black p-4 bg-white/[0.8] dark:bg-gray-900">
       <span class="flex flex-nowrap font-medium">
             Custo Total:  R$ {{ number_format($values['cost'],2) }}
        </span>
        <span class="flex flex-nowrap font-medium">
            Venda Total:  R$ {{ number_format($values['sale'],2) }}
       </span>
        <span class="flex flex-nowrap font-medium">
           Lucro Total:  {{ $values['profit']}}
       </span>

    </div>

    <livewire:components.show-products wire:loading.remove/>

</div>
