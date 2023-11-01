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
            class="flex flex-col w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border dark:border-2 border-black ">
            <div class="mb-2">
                <span class="font-medium">
                    Periodo:
                    @if ($date['start'])
                        <p class="my-4">
                            <span class="dark:bg-gray-700 p-2 rounded-lg border dark:border-2 border-black">
                                {{ $date['start'] }}
                            </span>
                             -
                            <span class="dark:bg-gray-700 p-2 rounded-lg border dark:border-2 border-black">
                                {{ $date['end'] }}
                            </span>
                        </p>
                    @endif

                </span>
            </div>
            <div class="flex justify-between w-full min-w-fit flex-wrap mb-4 gap-4">
                <span
                    class="flex flex-nowrap font-medium dark:bg-gray-700 p-4 rounded-lg border dark:border-2 border-black flex-grow">
                    Custo Total: R$ {{ $values['cost'] }}
                </span>
                <span
                    class="flex flex-nowrap font-medium dark:bg-gray-700  p-4 rounded-lg border dark:border-2 border-black flex-grow">
                    Venda Total: R$ {{ $values['sale'] }}
                </span>
                <span
                    class="flex flex-nowrap font-medium dark:bg-gray-700  p-4 rounded-lg border dark:border-2 border-black flex-grow">
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
                    <div class="flex justify-between w-full min-w-fit flex-wrap text-black p-2 rounded-lg">
                        <span
                            class="flex flex-nowrap w-full font-medium {{ "bg-[".$pieColors[$key]."]"}} p-2 rounded-lg justify-between">
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
        <div class=" w-full  border-2 border-black rounded-t-lg ">
            @foreach ($categories as $category)
                <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
                    <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                        <i class="{{ $category->icon }} text-xl mx-2"> </i>
                        <span class="font-bold text-xl"> {{ $category->name }}</span>
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
                                    <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                        <td class=" px-2 py-4">{{ $product['id'] }}</td>
                                        <td class=" px-2 py-4">{{ $product['name'] }}</td>
                                        <td class=" px-2 py-4">{{ $product['brand'] }}</td>
                                        <td class=" px-2 py-4">{{ $product['weight'] }}</td>
                                        <td class=" px-2 py-4">{{ $product['amount'] }}</td>
                                        <td class=" px-2 py-4">R$ {{ $product['cost'] }}</td>
                                        <td class=" px-2 py-4">R$ {{ $product['sale'] }}</td>
                                        <td class=" px-2 py-4">R$ {{ $product['profit'] }}</td>
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
