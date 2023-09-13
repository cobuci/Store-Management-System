<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Endereço</th>
        <th scope="col">Opções</th>
    </tr>
</thead>
@foreach ($data as $cliente)
    <tbody>
        <tr>
            <th scope="row">{{ $cliente->id }}</th>
            <td>{{ $cliente->name }}</td>
            <td> {{ $cliente->street }} , {{ $cliente->number }}</td>

            <td>
                <a href="{{ route('admin.cliente.perfil', $cliente->id) }}" class="btn btn-outline-dark shadow-sm"
                    data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                    style="border-radius: 10px" title="Verificar">
                    Verificar
                </a>
            </td>
        </tr>

    </tbody>
@endforeach
