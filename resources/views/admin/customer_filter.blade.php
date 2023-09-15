<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Endereço</th>
        <th scope="col">Opções</th>
    </tr>
</thead>
@foreach ($customers as $customer)
    <tbody>
        <tr>
            <th scope="row">{{ $customer->id }}</th>
            <td>{{ $customer->name }}</td>
            <td> {{ $customer->street }} , {{ $customer->number }}</td>

            <td>
                <a href="{{ route('admin.customer.profile', $customer->id) }}" class="btn btn-outline-dark shadow-sm"
                    data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                    style="border-radius: 10px" title="Verificar">
                    Verificar
                </a>
            </td>
        </tr>

    </tbody>
@endforeach
