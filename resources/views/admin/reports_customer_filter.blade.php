<thead>
<tr>
    <th>#</th>
    <th>Valor (Custo)</th>
    <th>Valor (Venda)</th>
    <th>Cliente</th>
    <th>Data</th>
    <th>TOTAL:</th>
</tr>
</thead>
@foreach ($data as $item)
    <tbody class="text-truncate text-dark">
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->cost }}<br></td>
        <td>{{ $item->price }}<br></td>
        <td>{{ $item->customer_name }}<br></td>
        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }}<br>
        </td>
        <td class="text-center">
            <form method="post" action="{{ route('order.status', $item->id) }}">

                @csrf
                <button class="btn btn-outline-primary" type="button"
                        style="margin-right: 10px;" data-bs-toggle="modal"
                        data-bs-target="#{{ 'modDetail' . $item->id }}">Detalhes
                </button>

                <button class="btn btn-outline-success" type="submit"
                        style="margin-right: 10px;width: 50%;">Confirmar
                </button>
            </form>
        </td>
    </tr>

    </tbody>
@endforeach
