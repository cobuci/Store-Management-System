@section('title', 'Estoque')
<div class="w-[100%]">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    <div
        class="flex flex-wrap w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border-2 border-black justify-between">
       <span class="flex flex-nowrap font-medium">
             Custo Total: R$ {{ $total_cost}}
        </span>
        <span class="flex flex-nowrap font-medium">
            Venda Total: R$ {{ $total_sale}}
       </span>
        <span class="flex flex-nowrap font-medium">
           Lucro Total: R$ {{ $total_profit}}
       </span>

    </div>
    <div class="flex flex-col overflow-x-auto w-[100%] min-w-fit border-2 border-black rounded-t-lg mt-6">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  min-w-fit " x-data="{ open: false }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-history text-xl mx-2"> </i>
                <span class="font-bold text-xl">Ultimos Produtos Cadastrados</span>
            </div>
            <div class="w-full" x-show="open" x-transition>
                <table class="w-full min-w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th class="border-r" scope="col">#</th>
                        <th class="border-r" scope="col">Produto</th>
                        <th class="border-r" scope="col">Marca</th>
                        <th class="border-r" scope="col">Peso</th>
                        <th class="border-r" scope="col">Preço Custo</th>
                        <th class="border-r" scope="col">Preço Venda</th>
                        <th class="border-r" scope="col">Quantidade</th>
                        <th class="border-r" scope="col">Validade</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                        @foreach($lastProducts as $product)
                    <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                        <td class="whitespace-nowrap px-2 py-4">{{$product->id}}</td>
                        <td class="whitespace-nowrap px-2 py-4">{{$product->name}}</td>
                        <td class="whitespace-nowrap px-2 py-4">{{$product->brand}}</td>
                        <td class="whitespace-nowrap px-2 py-4">{{$product->weight}}</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ {{$product->cost}}</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ {{$product->sale}}</td>
                        <td class="whitespace-nowrap px-2 py-4">{{$product->amount}}</td>
                        <td class="whitespace-nowrap px-2 py-4">{{$product->expiration_date}}</td>
                        <td class="whitespace-nowrap px-2 py-4">
                            <x-button info label="Editar"/>
                        </td>
                        <td class="whitespace-nowrap px-2 py-4">
                            <x-button negative label="Excluir" wire:click="deleteDialog({{$product->id}})"/>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($categories as $category)
            <div class="bg-white/[0.8] dark:bg-gray-900 w-full border-t-2" x-data="{ open: false }">
                <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                    <i class="{{$category->icon}} text-xl mx-2"> </i>
                    <span class="font-bold text-xl">{{ $category->name }}</span>
                </div>
                <div class="w-full" x-show="open" x-transition>
                    <table class="w-full min-w-full">
                        <thead class="border-b border-1">
                        <tr class="bg-white/[0.1]">
                            <th class="border-r" scope="col">#</th>
                            <th class="border-r" scope="col">Produto</th>
                            <th class="border-r" scope="col">Marca</th>
                            <th class="border-r" scope="col">Peso</th>
                            <th class="border-r" scope="col">Preço Custo</th>
                            <th class="border-r" scope="col">Preço Venda</th>
                            <th class="border-r" scope="col">Quantidade</th>
                            <th class="border-r" scope="col">Validade</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="dark:bg-gray-700">

                        @foreach ($category->products as $product)

                            <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                <td class="whitespace-nowrap px-2 py-4">{{$product->id}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->name}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->brand}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->weight}}</td>
                                <td class="whitespace-nowrap px-2 py-4">R$ {{$product->cost}}</td>
                                <td class="whitespace-nowrap px-2 py-4">R$ {{$product->sale}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->amount}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->expiration_date}}</td>
                                <td class="whitespace-nowrap px-2 py-4">
                                    <x-button info label="Editar"/>
                                </td>
                                <td class="whitespace-nowrap px-2 py-4">
                                    <x-button negative label="Excluir" wire:click="deleteDialog({{$product->id}})"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        @endforeach
    </div>


</div>
