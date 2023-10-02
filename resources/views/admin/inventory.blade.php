@section('title', 'Estoque')
<div class="w-[100%]">
    <x-notifications position="top-center" z-index="z-[1036]"/>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div
        class="flex flex-wrap w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border-2 border-black justify-between">
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
                    @foreach($lastProducts as $product)
                        <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                            <td class=" px-2 py-4">{{$product->id}}</td>
                            <td class=" px-2 py-4">{{$product->name}}</td>
                            <td class=" px-2 py-4">{{$product->brand}}</td>
                            <td class=" px-2 py-4">{{$product->weight}}</td>
                            <td class=" px-2 py-4">R$ {{$product->cost}}</td>
                            <td class=" px-2 py-4">R$ {{$product->sale}}</td>
                            <td class=" px-2 py-4">{{$product->amount}}</td>
                            <td class=" px-2 py-4">{{$product->expiration_date}}</td>
                            <td class=" px-2 py-4">
                                <x-button info label="Editar" wire:click="modalCardEdit({{$product->id}})"/>
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

                        @foreach ($category->products as $product)

                            <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                                <td class=" px-2 py-4">{{$product->id}}</td>
                                <td class=" px-2 py-4">{{$product->name}}</td>
                                <td class=" px-2 py-4">{{$product->brand}}</td>
                                <td class=" px-2 py-4">{{$product->weight}}</td>
                                <td class=" px-2 py-4">R$ {{$product->cost}}</td>
                                <td class=" px-2 py-4">R$ {{$product->sale}}</td>
                                <td class=" px-2 py-4">{{$product->amount}}</td>
                                <td class=" px-2 py-4">{{$product->expiration_date}}</td>
                                <td class=" px-2 py-4">
                                    <x-button info label="Editar" wire:click="modalCardEdit({{$product->id}})"/>
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

    <x-modal.card title="Editar o produto" blur wire:model.defer="cardModal" z-index="z-[1136]">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <x-input label="ID" wire:model="product.id" disabled/>
            </div>
            <x-select
                label="Categoria (*)"
                :options="$categories"
                option-label="name"
                option-value="id"
                name="categoria"
                wire:model="product.category_id"
                placeholder="Selecione a categoria"
            />
            <x-input label="Produto" placeholder="Nome do produto" wire:model="product.name"/>

            <div class="col-span-1 sm:col-span-2">

                <x-input icon="briefcase" label="Marca" placeholder="Marca" name="brand" wire:model="product.brand"/>

            </div>

            <x-input icon="scale" label="Unidade peso (*)" placeholder="Peso" name="weight"
                     wire:model="product.weight"/>
            <x-select label="Tipo peso" placeholder="Selecione o tipo do peso"
                      :options="[
                        ['name' => 'Mililitros', 'value'=>'ml'],
                        ['name' => 'Litros', 'value'=>'l'],
                        ['name' => 'Gramas', 'value'=>'g'],
                        ['name' => 'Kilogramas', 'value'=>'kg'],
                        ['name' => 'Unidade', 'value'=>'un'],
                 ]"
                      option-label="name"
                      wire:model="product.weight_type"
                      option-value="value"/>
            <x-inputs.number label="Quantidade" name="amount" wire:model="product.amount"/>
            <x-datetime-picker
                label="Validade"
                placeholder="Data de validade"
                display-format="DD-MM-YYYY"
                without-time="true"
                wire:model="product.expiration_date"
            />
            <x-inputs.currency label="Custo" prefix="R$" thousands="." decimal="," wire:model="product.cost"/>
            <x-inputs.currency label="Preço de Venda" prefix="R$" thousands="." decimal="," wire:model="product.sale"/>

        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Salvar" wire:click="productEdit" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

</div>
