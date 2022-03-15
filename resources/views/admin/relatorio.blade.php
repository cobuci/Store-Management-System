@extends('admin.master.layout')
@section('title', 'Relatório')
@section('content')

    <div class="container">
        <h1 class="text-center text-light">Relatório de Vendas</h1>
    </div>
    <div class="container" style="margin-top: 15px">
        <div class="row" style="padding-right: 16px; padding-left: 16px">
            <div class="col-12"
                style="background: rgba(255, 255, 255, 0.7);color: var(--bs-gray-900);border-radius: 10px;">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="text-dark">
                            <tr>
                                <th>#</th>
                                <th>Produto</th>
                                <th>Quant.</th>
                                <th>Valor (Custo)</th>
                                <th>Valor (Venda)</th>
                                <th>Desconto</th>
                                <th>Lucro</th>
                                <th>Pagamento</th>
                                <th>Cliente</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-truncate text-dark">
                            @foreach ($venda as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->produto }} - {{ $item->marca }}</td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>R$ {{ $item->custo }}</td>
                                    <td>R$ {{ $item->precoVenda }}<br /></td>
                                    <td>
                                        @if ($item->desconto > 0)
                                            R$ {{ $item->desconto }}
                                        @endif
                                    </td>
                                    <td>{{ Caixa::calcularLucro($item->precoVenda, $item->custo) }}</td>
                                    <td>{{ $item->formaPagamento }}<br /></td>
                                    <td>{{ $item->nomeCliente }}<br /></td>
                                    <td>{{ $item->data }}<br /></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal"
                                            data-bs-target="#{{ 'mod' . $item->id }}">
                                            Cancelar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col">
                <nav class="border rounded-pill shadow d-xl-flex justify-content-center align-items-center align-content-center align-self-center justify-content-xl-center align-items-xl-center"
                    style="background: rgba(248, 249, 250, 0.21)">
                    <ul class="pagination">
                        {{ $venda->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <!-- Modal Cancelar  -->
    @foreach ($venda as $item)
        <div class="modal fade" id="{{ 'mod' . $item->id }}" tabindex="-1"
            aria-labelledby="{{ 'mod' . $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ 'mod' . $item->id }}">Cancelar Venda #{{ $item->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('venda.destroy', $item->id) }}">
                            @method("DELETE")
                            @csrf
                            Produto: {{ $item->produto }} - {{ $item->marca }}
                            <br>
                            Preço: R${{ $item->precoVenda }}
                            <br>
                            Cliente: {{ $item->nomeCliente }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
