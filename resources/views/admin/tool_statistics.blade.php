@section('title', 'Estatisticas')
<div class="flex flex-col h-full w-full select-none">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    <div class="flex justify-center text-2xl mb-4">
        <span> Estatisticas</span>
    </div>
    <div class="dark:bg-gray-900 bg-white/[0.8] p-6 rounded-lg mb-4 min-w-fit border-2 border-black">
        <div class="text-xl mb-4">
            <span> Selecione o periodo desejado</span>
        </div>
        <x-datetime-picker
            label="Data Inicial"
            placeholder="Data Inicial"
            display-format="DD-MM-YYYY"
            without-time="true"
            wire:model.blur="date.start"
        />
        <x-datetime-picker
            label="Data Final"
            placeholder="Data Final"
            display-format="DD-MM-YYYY"
            without-time="true"
            wire:model.blur="date.end"
        />

    </div>

    <livewire:components.statistics />    


</div>
