@extends('admin.master.layout')
@section('title', 'Relatório')
@section('page-name', 'Relatório (Descontinuado)')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')

    <div class="row " style="padding-right: 16px; padding-left: 16px">
        <div class="col-12" style="background: rgba(255, 255, 255, 0.7);color: var(--bs-gray-900);border-radius: 10px;">
            <div class="table-responsive ">
                <table class="table table-sm  ">
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

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

@endsection
