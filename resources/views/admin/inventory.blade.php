@section('title', 'Estoque')
<div class="w-[100%]">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    <div class="flex flex-col overflow-x-auto w-[100%] border-2 border-black rounded-t-lg">

        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  min-w-fit " x-data="{ open: false }">
            <div class="p-2 cursor-pointer" @click="open = ! open">
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
                    <tr class="border-b">
                        <td class="whitespace-nowrap px-2 py-4">32</td>
                        <td class="whitespace-nowrap px-2 py-4">Coca - cola</td>
                        <td class="whitespace-nowrap px-2 py-4">Pepsico</td>
                        <td class="whitespace-nowrap px-2 py-4">320ml</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 10.99</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 20.90</td>
                        <td class="whitespace-nowrap px-2 py-4">320</td>
                        <td class="whitespace-nowrap px-2 py-4">31/12/2021</td>
                        <td class="whitespace-nowrap px-2 py-4">EXCLUIR</td>
                        <td class="whitespace-nowrap px-2 py-4">EDITAR</td>
                    </tr>
                    <tr class="border-b">
                        <td class="whitespace-nowrap px-2 py-4">32</td>
                        <td class="whitespace-nowrap px-2 py-4">Coca - cola</td>
                        <td class="whitespace-nowrap px-2 py-4">Pepsico</td>
                        <td class="whitespace-nowrap px-2 py-4">320ml</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 10.99</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 20.90</td>
                        <td class="whitespace-nowrap px-2 py-4">320</td>
                        <td class="whitespace-nowrap px-2 py-4">31/12/2021</td>
                        <td class="whitespace-nowrap px-2 py-4">EXCLUIR</td>
                        <td class="whitespace-nowrap px-2 py-4">EDITAR</td>
                    </tr>
                    <tr class="border-b">
                        <td class="whitespace-nowrap px-2 py-4">32</td>
                        <td class="whitespace-nowrap px-2 py-4">Coca - cola</td>
                        <td class="whitespace-nowrap px-2 py-4">Pepsico</td>
                        <td class="whitespace-nowrap px-2 py-4">320ml</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 10.99</td>
                        <td class="whitespace-nowrap px-2 py-4">R$ 20.90</td>
                        <td class="whitespace-nowrap px-2 py-4">320</td>
                        <td class="whitespace-nowrap px-2 py-4">31/12/2021</td>
                        <td class="whitespace-nowrap px-2 py-4">EXCLUIR</td>
                        <td class="whitespace-nowrap px-2 py-4">EDITAR</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @foreach($categories as $category)

            <div class="bg-white/[0.8] dark:bg-gray-900 min-w-fit  " x-data="{ open: false }">
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

                            <tr class="border-b">
                                <td class="whitespace-nowrap px-2 py-4">{{$product->id}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->name}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->brand}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->weight}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->cost}}</td>
                                <td class="whitespace-nowrap px-2 py-4">{{$product->sale}}</td>
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
