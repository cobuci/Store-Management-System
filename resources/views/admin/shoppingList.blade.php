
@section('title', 'Lista de Compras')
<div class="flex flex-wrap " style="margin-bottom: 10px;margin-top: 20px;">
    <span class="text-red-700"> Ableublaubalu</span>
    <div class="sm:w-full pr-4 pl-4 md:w-2/3 pr-4 pl-4 md:mx-1/5" style="border-style: none;">
        <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 shadow-lg md:w-full pr-4 pl-4 sm:w-full pr-4 pl-4"
             style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
            <div class="flex-auto p-6 shadow-sm"
                 style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                <div class="flex flex-wrap ">
                    <div class="sm:w-full pr-4 pl-4 md:w-1/3 pr-4 pl-4">
                        <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" type="text" id="product" wire:model="product"
                               placeholder="Produto" name="product"
                               style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                        @error('product')
                        <span class="text-red-700"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="sm:w-1/2 pr-4 pl-4 md:w-1/4 pr-4 pl-4">
                        <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" type="text" id="amount" wire:model="amount"
                               placeholder="Quantidade (*)" name="amount"
                               style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);"
                               inputmode="numeric">
                        @error('amount')
                        <span class="text-red-700"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="sm:w-1/2 pr-4 pl-4 md:w-1/4 pr-4 pl-4">
                        <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" type="text" id="cost" wire:model="cost"
                               placeholder="Valor (un.)" name="cost"
                               style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);"
                               inputmode="numeric">
                        @error('cost')
                        <span class="text-red-700"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:w-1/5 pr-4 pl-4">
                        <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline text-gray-100 border-gray-100 hover:bg-gray-100 hover:text-white bg-white hover:bg-gray-200 shadow-sm float-end"
                                wire:click="store"
                                style="border-radius: 10px;margin-bottom: 10px" title="Cadastrar">Adicionar
                        </button>
                    </div>
                </div>

                @foreach ($list as $item)
                    <div class="flex flex-wrap ">
                        <div class="relative flex-grow max-w-full flex-1 px-4"
                             style="padding-top: 1px;padding-bottom: 1px;margin-right: 12px;margin-left: 12px;">
                            <ul class="list-unstyled">
                                <li
                                    style="background: rgba(255,255,255,0.1);border-radius: 11px;padding-right: 3px;padding-left: 15px;border: 1px solid rgba(255,255,255,0.4);">
                                        <span class="float-end" style="margin-right: 10px;">
                                            <form method="POST" action="{{ route('order.shop.destroy', $item->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline fa fa-remove text-red-600" type="submit">
                                                </button>

                                            </form>
                                        </span> {{ $item->amount }} - {{ $item->product }} - R$ {{ $item->cost }}
                                    (un.)
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach

                <div class="flex flex-wrap " style="margin-top: 10px;">
                    <div class="relative flex-grow max-w-full flex-1 px-4">
                        <div>
                            <span class="font-monospace inline float-end">R$ {{ $total }}</span>
                            <span class="font-monospace inline float-end">Total:&nbsp;</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

