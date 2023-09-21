<div>
    @vite(['resources/js/chart.js' ])
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">
        <x-notifications position=""/>
        {{--    Balance--}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Saldo</span>
                <x-icon name="currency-dollar" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">R$ 0,00</div>

            <div class="mt-10">Média Diária (Setembro): R$ 455.90</div>

        </div>
        {{--    Day--}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Daily Income</span>
                <x-icon name="cash" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">R$ 0,00</div>
            <div>


                <div class="mt-5">+ 40%</div>
                <div>Last day: R$ 216,55 (R$ 93,20)</div>

            </div>
        </div>
        {{--    MONTH --}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 min-w-min ">
            <div class="flex flex-row justify-between">
                <span>Monthly Revenue</span>
                <x-icon name="calendar" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">R$ 0,00</div>
            <div>


                <div class="mt-5">+ 40%</div>
                <div>Last month: R$ 12164,55 (R$ 2393,20)</div>

            </div>
        </div>
        {{--    META--}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6 drop-shadow-xl z-1 md:col-span-3 min-w-min "
            wire:click="goalDialog">
            <div class="flex flex-row justify-between">
                <span>Monthly goal</span>
                <x-icon name="refresh" class="w-auto h-6"/>
            </div>
            <div class="text-2xl font-bold">R$ 20,00 / {{ $goal }}</div>
            <div class="mb-6 h-8  mt-5 w-full bg-neutral-400 dark:bg-neutral-300  ">
                <div class="h-8 bg-primary text-2xl text-center font-medium  text-gray-200 " style="width: 25%">
                    23%
                </div>
            </div>

        </div>

        <x-dialog id="goalDialog" title="Meta" >
            <x-input label="Defina a nova meta" wire:model="goal" />
        </x-dialog>

        {{--    CHART  --}}
        <div class="bg-white/[.80] rounded-lg dark:bg-gray-700 px-6 py-6drop-shadow-xl z-1 md:col-span-3 min-h-[305px]   ">
            <div class=" w-[100%]">
                <canvas class="" id="dashboard-line"></canvas>
            </div>
        </div>

        <input type="hidden" id="monthsChart" value="{{ $monthsChart }}"/>
        @for ($i = $monthsChart; $i >= 0; $i--)
            <input type="hidden" id="{{ 'hiddeninput' . $i }}"
                   value="{{ Dashboard::checkMonth(Dashboard::month($i)) }}"/>

            <input type="hidden" id="{{ 'hiddeninputValue' . $i }}" value="{{ Dashboard::salesMonth($i) }}"/>

            <input type="hidden" id="{{ 'hiddeninputProfit' . $i }}" value="{{ Dashboard::profitMonth($i) }}"/>
        @endfor

    </div>


</div>
