@extends('admin.master.layout')
@section('title', 'Clientes')
@section('content')

    <h1 class="text-center text-light">Clientes</h1>


    <div class="row" style="margin-bottom: 10px">

        <div class="form-group">
            <input class="form-control" type="text" id="search-input" name="search" placeholder="Pesquisar">
        </div>

        <table class="table tabela-dados">
            
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
                        <td>{{ $cliente->nome }}</td>
                        <td> {{ $cliente->rua }} , {{ $cliente->numero }}</td>
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
                url: '{{ route('filtrar.cliente') }}',
                type: 'GET',
                data: {
                    search: searchValue
                },
                success: function(response) {
                    $('.tabela-dados').html(response);
                },
                error: function(xhr) {
                    // Tratar erros, se necessário
                }
            });
        });
    });
</script>
