@extends('admin.master.layout')
@section('title', 'Clientes')
@section('page-name', 'Clientes')
@section('content')

    <div class="row" style="margin-bottom: 10px">


        <input class="form-control" type="text" id="search-input" name="search" placeholder="Pesquisar">


        <table class="table tabela-data bg-light">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            @foreach ($clientes as $cliente)
                <tbody>
                    <tr>
                        <th scope="row">{{ $cliente->id }}</th>
                        <td>{{ $cliente->name }}</td>
                        <td> {{ $cliente->street }} , {{ $cliente->number }}</td>
                        <td>
                            <a href="{{ route('admin.cliente.perfil', $cliente->id) }}"
                                class="btn btn-outline-dark shadow-sm" data-bs-toggle="tooltip" data-bss-tooltip=""
                                data-bs-placement="bottom" type="submit" style="border-radius: 10px" title="Verificar">
                                Verificar
                            </a>
                        </td>
                    </tr>
                </tbody>
            @endforeach

        </table>
    </div>

@endsection


<script src="{{ asset('admin/jquery.js') }}"></script>



<script>
    $(document).ready(function() {
        $('#search-input').on('input', function() {
            var searchValue = $(this).val();

            $.ajax({
                url: '{{ route('customer.filter') }}',
                type: 'GET',
                data: {
                    search: searchValue
                },
                success: function(response) {
                    $('.tabela-data').html(response);
                },
                error: function(xhr) {
                    // Tratar erros, se necessário
                }
            });
        });
    });
</script>
