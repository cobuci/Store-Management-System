@section('title', 'Compras')
<div class="w-full max-w-4xl select-none">
    <h1 class="grid justify-items-center font-bold text-2xl mb-6 w-full"> Contas a pagar </h1>
    <div
        class="flex flex-wrap w-full p-4 min-w-fit bg-white/[0.8] dark:bg-gray-900 rounded-lg border-2 border-black justify-between">

        <span class="flex flex-nowrap font-medium">
           Total Devido: R$ {{ $totalCost  }}
       </span>

    </div>
    <div class="flex flex-col  border-2 border-black rounded-t-lg mt-6">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  " x-data="{ open: false }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-history text-xl mx-2"> </i>
                <span class="font-bold text-xl">A pagar</span>
            </div>
            <div class="overflow-auto" x-show="open" x-transition>

                <table class="w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th scope="col">#</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Custo Unidade</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Vencimento</th>
                        <th class="" scope="col"></th>
                        <th class="" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">
                    @foreach ($unpaidPurchases as $unpaidPurchase)
                        <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                            <td class="whitespace-nowrap px-2 py-4 ">{{ $unpaidPurchase->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4 ">{{ $unpaidPurchase->product_name }} - {{ $unpaidPurchase->product_brand }} ({{ $unpaidPurchase->product_weight }})</td>
                            <td class="whitespace-nowrap px-2 py-4 ">{{ $unpaidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4 ">R$ {{ $unpaidPurchase->unit_cost }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ $unpaidPurchase->unit_cost * $unpaidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4 ">{{ $unpaidPurchase->expiration_date }}</td>
                            <td class="whitespace-nowrap px-2 py-4 ">
                                <x-button class="w-full my-4" icon="check" squared positive label="Pagar"
                                          wire:click="dialogPay({{ $unpaidPurchase->id }})"/>
                            </td>
                            <td class="whitespace-nowrap px-2 py-4 ">
                                <x-button class="w-full my-4" icon="check" squared negative label="Cancelar"
                                          wire:click="dialogCancel({{ $unpaidPurchase->id }})"/>
                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: true }">
            <div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
                <i class="fa fa-check text-xl mx-2"> </i>
                <span class="font-bold text-xl">Pago</span>
            </div>
            <div class="overflow-auto" x-show="open" x-transition>
                <table class="w-full">
                    <thead class="border-b border-1">
                    <tr class="bg-white/[0.1]">
                        <th  scope="col">#</th>
                        <th  scope="col">Produto</th>
                        <th  scope="col">Quantidade</th>
                        <th  scope="col">Custo Unidade</th>
                        <th scope="col">Custo Total</th>
                        <th  scope="col">Data Pagamento</th>


                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">

                    @foreach ($paidPurchases as $paidPurchase)
                        <tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->product_name }} - {{ $paidPurchase->product_brand }} ({{ $paidPurchase->product_weight }})</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ $paidPurchase->unit_cost }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ $paidPurchase->unit_cost * $paidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->updated_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $paidPurchases->links() }}
            </div>
        </div>
    </div>
</div>
