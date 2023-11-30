@section('title', 'Dashboard')
<div>
    @vite(['resources/js/chart.js' ])

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 select-none">
        <x-notifications position="top-center"  z-index="z-[1035]"/>
        {{--    Balance--}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Saldo</span>
                <x-icon name="currency-dollar" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">R$ {{ number_format($data['balance'],2) }}</div>

            <div class="mt-10">Média Diária ({{ $data['month'] }}): R$ {{ number_format($data['dailyAverage'],2) }}</div>

        </div>
        {{--    Day--}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Daily Income</span>
                <x-icon name="cash" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">
                    R$ {{ number_format($sales['today'],2) }}
                <span class="text-sm text-green-500">(R$ {{ number_format($profit['today'],2) }})</span>

            </div>
            <div>
                <div class="mt-5"> <span class="text-sm {{ $percent['today'] >= 0 ? 'text-green-500' : 'text-red-500' }}">{{ $percent['today'] }}%</span></div>
                <div>Last day: R$ {{ $sales['yesterday'] }} (R$ {{number_format($profit['yesterday'],2)}})</div>
            </div>
        </div>
        {{--    MONTH --}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Monthly Revenue</span>
                <x-icon name="calendar" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">
                R$ {{  number_format($sales['month'],2) }}
                <span class="text-sm text-green-500">(R$ {{ number_format($profit['month'],2) }})</span>

            </div>
            <div>
                <div class="mt-5">
                    <span class="text-sm {{ $percent['month'] >= 0 ? 'text-green-500' : 'text-red-500' }}">{{ $percent['month'] }}%</span></div>

                <div>Last month: R$ {{  $sales['lastMonth'] }} (R$ {{ number_format($profit['lastMonth'],2) }})</div>

            </div>
        </div>
        {{--    META--}}
        <div
            class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 md:col-span-3 min-w-min cursor-pointer "
            wire:click="goalDialog">
            <div class="flex flex-row justify-between ">
                <span>Monthly goal</span>
                <x-icon name="refresh" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold ">R$ {{ ($sales['month']) }} / {{ number_format($data['goal'],2) }}</div>
            <div class="mb-6 h-8  mt-5 w-full bg-neutral-400 dark:bg-neutral-300  rounded-lg  ">
                <div class="h-8 bg-primary text-2xl text-center font-medium text-gray-800 max-w-full"
                     style="width:{{ $percent['goal'] }}%">
                    {{ $percent['goal'] }}%
                </div>
            </div>

        </div>
        <x-dialog id="goalDialog" title="Meta"  z-index="z-[1035]" >
            <x-input label="Defina a nova meta" wire:model="data.goal"/>
        </x-dialog>

        {{--    CHART  --}}
        <div wire:ignore
            class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6drop-shadow-xl z-1 md:col-span-3">
            <div class=" w-full sm:w-auto">
                <canvas class="" id="dashboard-line"></canvas>
            </div>
        </div>


        <input type="hidden" id="monthsChart" value="{{ $data['monthsChart'] }}"/>
        @for ($i =  $data['monthsChart']; $i >= 0; $i--)
            <input type="hidden" id="{{ 'hiddeninput' . $i }}"
                   value="{{ $this->checkMonth($this->getLastSaleMonth($i))}} "/>

            <input type="hidden" id="{{ 'hiddeninputValue' . $i }}" value="{{ $this->getSalesIncomeForLastMonth($i) }}"/>

            <input type="hidden" id="{{ 'hiddeninputProfit' . $i }}" value="{{ $this->getMonthProfit($i) }}"/>
        @endfor

    </div>
</div>
