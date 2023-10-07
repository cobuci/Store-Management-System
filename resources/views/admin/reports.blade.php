@php use Carbon\Carbon; @endphp
@section('title', 'Relatório')
<div class="w-full select-none">
	<h1 class="grid justify-items-center font-bold text-2xl mb-6 w-full"> Relatórios de Vendas </h1>
	<div class="flex flex-col  border-2 border-black rounded-t-lg mt-6">
		<div class="rounded-t-lg bg-white/[0.8] dark:bg-gray-900  " x-data="{ open: false }">
			<div class="p-2 cursor-pointer dark:hover:bg-gray-700 hover:bg-gray-400" @click="open = ! open">
				<i class="fa fa-history text-xl mx-2"> </i>
				<span class="font-bold text-xl">A pagar</span>
			</div>
			<div class="overflow-auto" x-show="open" x-transition>
				<x-input class="my-2" placeholder="Pesquisar" wire:model.live="search"/>
				<table class="w-full">
					<thead class="border-b border-1">
					<tr class="bg-white/[0.1]">
						<th scope="col">#</th>
						<th scope="col">Custo</th>
						<th scope="col">Venda</th>
						<th scope="col">Cliente</th>
						<th scope="col">Data</th>
						<th class="" scope="col">Total:</th>
						<th class="border-r" scope="col">R$ {{ $total }}</th>
					</tr>
					</thead>
					<tbody class="dark:bg-gray-700">
					@foreach ($unconfirmedSale as $sale)
						<tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
							<td class="whitespace-nowrap px-2 py-4 ">{{ $sale->id }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">R$ {{ $sale->cost }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">R$ {{ $sale->price }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">{{ $sale->customer_name }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">
								{{ Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">
								<x-button class="w-full" info label="Detalhes"
								          wire:click="modalSale({{ $sale->id }})"/>
							</td>
							<td class="whitespace-nowrap px-2 py-4">
								<x-button class="w-full" positive label="Confirmar"
								          wire:click="confirmDialog({{ $sale->id }})"/>
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
						<th scope="col">#</th>
						<th scope="col">Custo</th>
						<th scope="col">Venda</th>
						<th scope="col">Lucro</th>
						<th scope="col">Cliente</th>
						<th scope="col">Data</th>
						<th scope="col"></th>

					</tr>
					</thead>
					<tbody class="dark:bg-gray-700">
					@foreach ($sales as $sale)
						<tr class="border-b dark:hover:bg-gray-600 hover:bg-gray-400">
							<td class="whitespace-nowrap px-2 py-4 ">{{ $sale->id }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">R$ {{ $sale->cost }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">R$ {{ $sale->price }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">R$ {{ $sale->price - $sale->cost }}
							</td>
							<td class="whitespace-nowrap px-2 py-4 ">{{ $sale->customer_name }}</td>
							<td class="whitespace-nowrap px-2 py-4 ">
								{{ Carbon::parse($sale->created_at)->format('d/m/yy') }}</td>

							<td class="whitespace-nowrap px-2 py-4 ">
								<x-button class="w-full" info label="Detalhes"
								          wire:click="modalSale({{ $sale->id }})"/>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>

				{{ $sales->links() }}
			</div>
		</div>
	</div>


	<x-modal.card title="Detalhes da venda" blur wire:model.defer="modal" z-index="z-[1136]">

		<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

			<x-input label="ID" wire:model="sale_detail.id" disabled/>
			<x-input label="Data" wire:model="sale_detail.created_at" disabled/>
			<x-input label="Cliente" wire:model="sale_detail.customer_name" disabled/>
			<x-input label="Forma de pagamento" wire:model="sale_detail.payment_method" disabled/>
			<x-input label="Custo" wire:model="sale_detail.cost" disabled/>
			<x-input label="Desconto" wire:model="sale_detail.discount" disabled/>
			<x-input label="Venda" wire:model="sale_detail.price" disabled/>
			<x-input label="Lucro" wire:model="sale_detail.profit" disabled/>

			<div
					class="md:col-span-2 flex flex-wrap bg-white/[.80] mt-5 rounded-lg dark:bg-gray-700 px-6 py-6 h-auto w-auto min-w-min items-center justify-center drop-shadow-xl">
				<div class="flex-1 p-2">
					<ul class="grid w-[100%] gap-4">
						@foreach ($products as $product)
							<li
									class="flex justify-between h-18 min-w-fit bg-white dark:bg-gray-900 rounded-lg shadow-lg">
								<div class="p-2">
									<div>
										<span>{{ $product->product_name }}</span>
										<span>({{ $product->weight }})</span>
									</div>
									<div>
										<span>{{ $product->product_brand }}</span>
									</div>
								</div>
								<div
										class="bg-gray-600 text-white rounded-r-lg  w-8 min-w-fit flex items-center justify-center ">
									<span>{{ $product->amount }}</span>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		<x-slot name="footer">
			<div class="flex justify-between gap-x-4">
				<div>
					<x-button red label="Cancelar" wire:click="cancelDialog({{ $sale_detail['id'] }})"/>
				</div>
				<div class="flex gap-4 ">
					<x-button info label="Recibo" href="{{ route('invoice', $sale_detail['id']) }}"/>
                    <x-button indigo label="Fechar" x-on:click="close"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>

</div>
