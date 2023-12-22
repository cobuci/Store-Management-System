@php use Carbon\Carbon; @endphp
@section('title', 'Compras')
<div class="w-full max-w-4xl select-none">
    <h1 class="mb-6 grid w-full justify-items-center text-2xl font-bold"> Contas a pagar </h1>
    <div
        class="flex w-full min-w-fit flex-wrap justify-between rounded-lg border-2 border-black p-4 font-medium bg-white/[0.8] dark:bg-gray-900">

        <span class="flex flex-nowrap">
           Total Devido: R$  {{ $costs['total'] }}
       </span>

        <span>
            Vencido: R$  {{ $costs['expired'] }}
        </span>

        <span>
            Para este mês: R$ {{ $costs['thisMonth'] }}
        </span>


    </div>
    <div class="mt-6 flex flex-col rounded-t-lg border-2 border-black">
        <div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900" x-data="{ open: false }">
            <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                <i class="mx-2 text-xl fa fa-history"> </i>
                <span class="text-xl font-bold">A pagar</span>
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
                        <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                            <td class="whitespace-nowrap px-2 py-4">{{ $unpaidPurchase->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $unpaidPurchase->product_name }}
                                - {{ $unpaidPurchase->product_brand }} ({{ $unpaidPurchase->product_weight }})
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $unpaidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ $unpaidPurchase->unit_cost }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                R$ {{ $unpaidPurchase->unit_cost * $unpaidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{  Carbon::parse( $unpaidPurchase->expiration_date)->format('d-m-y') }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button class="my-4 w-full" icon="check" squared positive label="Pagar"
                                          wire:click="dialogPay({{ $unpaidPurchase->id }})"/>
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">
                                <x-button class="my-4 w-full" icon="check" squared negative label="Cancelar"
                                          wire:click="dialogCancel({{ $unpaidPurchase->id }})"/>
                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/[0.8] dark:bg-gray-900" x-data="{ open: true }">
            <div class="cursor-pointer p-2 hover:bg-gray-400 dark:hover:bg-gray-700" @click="open = ! open">
                <i class="mx-2 text-xl fa fa-check"> </i>
                <span class="text-xl font-bold">Pago</span>
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
                        <th scope="col">Data Pagamento</th>
                        <th scope="col">Vencimento</th>

                    </tr>
                    </thead>
                    <tbody class="dark:bg-gray-700">

                    @foreach ($paidPurchases as $paidPurchase)
                        <tr class="border-b hover:bg-gray-400 dark:hover:bg-gray-600">
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->id }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->product_name }}
                                - {{ $paidPurchase->product_brand }} ({{ $paidPurchase->product_weight }})
                            </td>
                            <td class="whitespace-nowrap px-2 py-4">{{ $paidPurchase->amount }}</td>
                            <td class="whitespace-nowrap px-2 py-4">R$ {{ $paidPurchase->unit_cost }}</td>
                            <td class="whitespace-nowrap px-2 py-4">
                                R$ {{ $paidPurchase->unit_cost * $paidPurchase->amount }}</td>

                            <td class="whitespace-nowrap px-2 py-4">{{ Carbon::parse( $paidPurchase->updated_at)->format('d-m-y') }}</td>
                            <td class="whitespace-nowrap px-2 py-4">{{  Carbon::parse( $paidPurchase->expiration_date)->format('d-m-y') }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $paidPurchases->links() }}
            </div>
        </div>
    </div>
</div>
