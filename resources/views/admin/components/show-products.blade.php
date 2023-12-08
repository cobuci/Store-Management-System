<div>
    <div class=" w-full  border-2 border-black rounded-t-lg mt-6">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-history text-xl mx-2"> </i>
                <span class="font-bold text-xl">Ultimos Produtos Cadastrados</span>
            </div>
            <div class="overflow-auto" x-show="open" x-transition>
                <table class="w-full whitespace-nowrap">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th class="border-r">#</th>
                        <th class="border-r">Produto</th>
                        <th class="border-r">Marca</th>
                        <th class="border-r">Peso</th>
                        <th class="border-r">Preço Custo</th>
                        <th class="border-r">Preço Venda</th>
                        <th class="border-r">Quantidade</th>
                        <th class="border-r">Validade</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach($lastProducts as $item)
                        <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                            <td class=" px-2 py-4">{{$item->id}}</td>
                            <td class=" px-2 py-4">{{$item->name}}</td>
                            <td class=" px-2 py-4">{{$item->brand}}</td>
                            <td class=" px-2 py-4">{{$item->weight}}</td>
                            <td class=" px-2 py-4">R$ {{$item->cost}}</td>
                            <td class=" px-2 py-4">R$ {{$item->sale}}</td>
                            <td class=" px-2 py-4">{{$item->amount}}</td>
                            <td class=" px-2 py-4">{{$item->expiration_date}}</td>
                            <td class=" px-2 py-4">
                                @livewire('components.edit-product', ['product' => $item, 'categories' => $categories], key("editlast-"."$item->id"))
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button negative label="Excluir" wire:click="deleteDialog({{$item->id}})"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($categories as $category)
            <div class="bg-white/[0.8] dark:bg-gray-900  border-t-2  " x-data="{ open: false }">
                <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                    <i class="{{$category->icon}} text-xl mx-2"> </i>
                    <span class="font-bold text-xl">{{ $category->name }}</span>
                </div>
                <div class="overflow-auto" x-show="open" x-transition>
                    <table class="w-full whitespace-nowrap">
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

                        @foreach ($category->products as $item)

                            <tr class="border-b {{ $item->amount > 0 ? null : 'dark:bg-red-900 bg-red-400'}} dark:hover:bg-gray-600 hover:bg-gray-400">
                                <td class="px-2 py-4">{{$item->id}}</td>
                                <td class="px-2 py-4">{{$item->name}}</td>
                                <td class="px-2 py-4">{{$item->brand}}</td>
                                <td class="px-2 py-4">{{$item->weight}}</td>
                                <td class="px-2 py-4">R$ {{$item->cost}}</td>
                                <td class="px-2 py-4">R$ {{$item->sale}}</td>
                                <td class="px-2 py-4">{{$item->amount}}</td>
                                <td class="px-2 py-4">{{$item->expiration_date}}</td>
                                <td class="px-2 py-4">
                                    @livewire('components.edit-product', ['product' => $item, 'categories' => $categories], key("edit-"."$item->id"))

                                </td>
                                <td class="whitespace-nowrap px-2 py-4">
                                    <x-button negative label="Excluir" wire:click="deleteDialog({{$item->id}})"/>
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
