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
    <div
        class="flex flex-col w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border-2 border-black ">
        <div class="mb-2">
               <span class=" font-medium">
                Periodo: {{ $date['start']}} - {{ $date['end']}}
               </span>
        </div>
        <div class="flex justify-between w-full min-w-fit flex-wrap">
            <span class="flex flex-nowrap font-medium">
                Custo Total: R$ {{ $values['cost']}}
            </span>
            <span class="flex flex-nowrap font-medium">
                Venda Total: R$ {{ $values['sale']}}
            </span>
            <span class="flex flex-nowrap font-medium">
                Lucro Total: R$ {{ $values['profit']}}
            </span>
        </div>

    </div>
    <div class=" w-full  border-2 border-black rounded-t-lg mt-6">
        @foreach($categories as $category)
            <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
                <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                    <i class="{{$category->icon}} text-xl mx-2"> </i>
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
                        @foreach($products as $product)
                            @if($product['category_id'] == $category->id)
                                <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                    <td class=" px-2 py-4">{{$product['id']}}</td>
                                    <td class=" px-2 py-4">{{$product['name']}}</td>
                                    <td class=" px-2 py-4">{{$product['brand']}}</td>
                                    <td class=" px-2 py-4">{{$product['weight']}}</td>
                                    <td class=" px-2 py-4">{{$product['amount']}}</td>
                                    <td class=" px-2 py-4">R$ {{$product['cost']}}</td>
                                    <td class=" px-2 py-4">R$ {{$product['sale']}}</td>
                                    <td class=" px-2 py-4">R$ {{$product['profit']}}</td>
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
