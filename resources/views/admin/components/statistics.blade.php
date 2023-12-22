<div>
    <ul class="mb-5 flex list-none flex-col flex-wrap pl-0 md:flex-row" role="tablist" data-te-nav-ref>
        {{--        Valores         --}}
        <li role="presentation">
            <a class="
            my-2 block rounded-lg bg-neutral-100 px-7
            border-black  border dark:border-2
            pb-3.5 pt-4 text-xs font-medium uppercase
            leading-tight
            cursor-pointer
            text-neutral-500
            data-[te-nav-active]:!bg-gray-400
            dark:data-[te-nav-active]:!bg-gray-700
            data-[te-nav-active]:text-black
            dark:bg-gray-900
            dark:text-white
            dark:data-[te-nav-active]:text-white
            md:mr-4"
               data-te-toggle="pill" data-te-target="#pills-values" data-te-nav-active role="tab"
               aria-controls="pills-values" aria-selected="true">Valores</a>
        </li>
        {{--        Produtos         --}}
        <li role="presentation">
            <a class="
            my-2 block rounded-lg bg-neutral-100 px-7
            border-black  border dark:border-2
            pb-3.5 pt-4 text-xs font-medium uppercase
            leading-tight
            cursor-pointer
            text-neutral-500
            data-[te-nav-active]:!bg-gray-400
            dark:data-[te-nav-active]:!bg-gray-700
            data-[te-nav-active]:text-black
            dark:bg-gray-900
            dark:text-white
            dark:data-[te-nav-active]:text-white
            md:mr-4"
               data-te-toggle="pill" data-te-target="#pills-products" role="tab" aria-controls="pills-products"
               aria-selected="false">Produtos</a>
        </li>
    </ul>
    {{--        Valores         --}}
    <div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
         id="pills-values" role="tabpanel" data-te-tab-active>
        <div
            class="flex w-full min-w-fit flex-col rounded-lg border border-black p-4 bg-white/[0.8] dark:border-2 dark:bg-gray-900">
            <div class="mb-2">
                <span class="font-medium">
                    Periodo:
                    @if ($date['start'])
                        <p class="my-4">
                            <span class="rounded-lg border border-black p-2 dark:border-2 dark:bg-gray-700">
                                {{ $date['start'] }}
                            </span>
                             -
                            <span class="rounded-lg border border-black p-2 dark:border-2 dark:bg-gray-700">
                                {{ $date['end'] }}
                            </span>
                        </p>
                    @endif

                </span>
            </div>
            <div class="mb-4 flex w-full min-w-fit flex-wrap justify-between gap-4">
                <span
                    class="flex flex-grow flex-nowrap rounded-lg border border-black p-4 font-medium dark:border-2 dark:bg-gray-700">
                    Custo Total: R$ {{ $values['cost'] }}
                </span>
                <span
                    class="flex flex-grow flex-nowrap rounded-lg border border-black p-4 font-medium dark:border-2 dark:bg-gray-700">
                    Venda Total: R$ {{ $values['sale'] }}
                </span>
                <span
                    class="flex flex-grow flex-nowrap rounded-lg border border-black p-4 font-medium dark:border-2 dark:bg-gray-700">
                    Lucro Total: R$ {{ $values['profit'] }}
                </span>
            </div>
            <div class="overflow-hidden">
                @if ($date['start'])
                    <div class="h-[300px] h-min-fit">
                        <livewire:livewire-pie-chart
                            key="{{ $this->pieChartModel->reactiveKey()}}"
                            :pie-chart-model="$this->pieChartModel"
                        />
                    </div>
                @endif

                @foreach ($payment_method as $key => $value)
                    <div class="flex w-full min-w-fit flex-wrap justify-between rounded-lg p-2 text-black">
                        <span
                            class="flex flex-nowrap w-full font-medium {{ "bg-[".$pieColors[$key]."]"}} bg-white p-2 rounded-lg justify-between">
                          <span>
                              {{ $key }}:
                          </span>
                          <span>
                            R$ {{ $value }}
                          </span>
                        </span>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    {{--        Produtos         --}}
    <div class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
         id="pills-products" role="tabpanel">
        <div class="w-full rounded-t-lg border-2 border-black">
            @foreach ($categories as $category)
                <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
                    <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                        <i class="{{ $category->icon }} text-xl mx-2"> </i>
                        <span class="text-xl font-bold"> {{ $category->name }}</span>
                    </div>
                    <div class="overflow-auto" x-show="open" x-transition>
                        <table class="w-full whitespace-nowrap">
                            <thead class="border-b border-1">
                            <tr class="bg-white/[0.1]">
                                <th class="border-r">#</th>
                                <th class="border-r">Produto</th>
                                <th class="border-r">Marca</th>
                                <th class="border-r">Peso</th>
                                <th class="border-r">Qt. Vendida</th>
                                <th class="border-r">Custo Total</th>
                                <th class="border-r">Venda Total</th>
                                <th class="border-r">Lucro</th>
                            </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700">
                            @foreach ($products as $product)
                                @if ($product['category_id'] == $category->id)
                                    <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                                        <td class="px-2 py-4">{{ $product['id'] }}</td>
                                        <td class="px-2 py-4">{{ $product['name'] }}</td>
                                        <td class="px-2 py-4">{{ $product['brand'] }}</td>
                                        <td class="px-2 py-4">{{ $product['weight'] }}</td>
                                        <td class="px-2 py-4">{{ $product['amount'] }}</td>
                                        <td class="px-2 py-4">R$ {{ $product['cost'] }}</td>
                                        <td class="px-2 py-4">R$ {{ $product['sale'] }}</td>
                                        <td class="px-2 py-4">R$ {{ $product['profit'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
<script>
    window.keysArray = @json(array_keys($payment_method));
    window.valuesArray =@json(array_values($payment_method));
</script>
