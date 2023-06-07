@extends('admin.master.layout')
@section('title', 'Relatório')
@section('page-name', 'Relatório')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')

    <div class="col-12 col-sm-12 col-md-12">
        <div class="font-monospace text-truncate">
            <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1"
                href="#collapse-1" role="button"
                style="border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;"><span
                    class="float-end">
                    <i class="fa fa-chevron-down text-white"></i>
                </span>
                <span class="float-start" style="margin-right: 10px;">
                    <i class="fa fa-history text-center text-white" style="width: 30px;height: 30px;"></i>
                </span>A Pagar
            </a>
            <div class="collapse col-md-12" id="collapse-1">
                <div class="card ">
                    <div class="card-body" style="padding: 0px;">

                        <input class="form-control" type="text" id="search-input" name="search" placeholder="Pesquisar">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-bordered tabela-dados">
                                <thead class="text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Valor (Custo)</th>
                                        <th>Valor (Venda)</th>
                                        <th>Cliente</th>
                                        <th>Data</th>
                                        <th>TOTAL: {{ $total }}</th>

                                    </tr>
                                </thead>
                                <tbody class="text-truncate text-dark ">
                                    @foreach ($unconfirmedSale as $item)
                                        @if ($item->status_pagamento == 0)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->custo }}<br></td>
                                                <td>{{ $item->precoVenda }}<br></td>
                                                <td>{{ $item->nomeCliente }}<br></td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/yy') }}<br>
                                                </td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('order.status', $item->id) }}">

                                                        @csrf
                                                        <button class="btn btn-outline-primary" type="button"
                                                            style="margin-right: 10px;" data-bs-toggle="modal"
                                                            data-bs-target="#{{ 'modDetail' . $item->id }}">Detalhes
                                                        </button>

                                                        <button class="btn btn-outline-success" type="submit"
                                                            style="margin-right: 10px;width: 50%;">Confirmar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="font-monospace text-truncate">
            <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-2"
                href="#collapse-2" role="button"
                style="border-radius: 0px;border-top-left-radius: 0;border-top-right-radius: 0;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;"><span
                    class="float-end">
                    <i class="fa fa-chevron-down text-white"></i>
                </span>
                <span class="float-start" style="margin-right: 10px;"><i class="fa fa-check text-center text-white"
                        style="width: 30px;height: 30px;"></i>
                </span>Pago
            </a>
            <div class="collapse show col-md-12" id="collapse-2">
                <div class="card">
                    <div class="card-body " style="padding: 0px;">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-bordered">
                                <thead class="text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Valor (Custo)</th>
                                        <th>Valor (Venda)</th>
                                        <th>Lucro</th>
                                        <th>Cliente</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody class="text-truncate text-dark">
                                    @foreach ($venda as $item)                                       
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>R$ {{ $item->custo }}<br></td>
                                                <td>R$ {{ $item->precoVenda }}<br></td>
                                                <td>R$ {{ $item->precoVenda - $item->custo }}<br></td>
                                                <td>{{ $item->nomeCliente }}<br></td>
                                                <td>{{ $item->data }}<br></td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        style="margin-right: 10px;" data-bs-toggle="modal"
                                                        data-bs-target="#{{ 'modDetail' . $item->id }}">Detalhes
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

   


    @foreach ($modalArray as $item)
        <div class="modal fade" id="{{ 'mod' . $item->id }}" tabindex="-1" aria-labelledby="{{ 'mod' . $item->id }}"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ 'mod' . $item->id }}">Cancelar Venda
                            #{{ $item->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('order.destroy', $item->id) }}">
                            @method('DELETE')
                            @csrf
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


        <div class="modal fade" tabindex="-1" id="{{ 'modDetail' . $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <div class="modal-header text-light"
                        style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                        <h4 class="modal-title  text-light">#{{ $item->id }}</h4><button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body font-monospace" style="background: #3d3d3d;">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-12 text-nowrap text-light"
                                    style="border-radius: 9px;padding-top: 15px;border-width: 2px;border-color: #8c61ff;">
                                    <h2 class="text-uppercase text-center text-light" style="margin-bottom: 16px;">Valores
                                    </h2>
                                    <p>
                                        <span class="float-end">
                                            R$ {{ $item->custo }}
                                        </span>
                                        Custo:
                                    </p>
                                    <hr>
                                    <p>
                                        Desconto:
                                        <span class="float-end">
                                            R$ {{ $item->desconto == null ? '0.00' : $item->desconto }}
                                        </span>
                                    </p>
                                    <hr>
                                    <p>
                                        Venda:
                                        <span class="float-end">
                                            R$ {{ $item->precoVenda }}
                                        </span>
                                    </p>
                                    <hr>
                                    <p>
                                        Lucro:
                                        <span class="float-end">
                                            R$ {{ $item->precoVenda - $item->custo }}
                                        </span>
                                    </p>
                                    <hr>
                                    <ul class="list-unstyled"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-12 text-nowrap text-light"
                                    style="border-radius: 9px;border-top-left-radius: 0;border-top-right-radius: 0;border-width: 2px;border-color: #8c61ff;">
                                    <h2 class="text-uppercase text-center  text-light" style="margin-bottom: 16px;">Produtos
                                    </h2>
                                    <ul class="list-unstyled">
                                        @foreach (Order::findOrder($item->order_id) as $prod)
                                            <li
                                                style="background: rgba(255,255,255,0.1);border-radius: 11px;padding-right: 3px;padding-left: 15px;margin-bottom: 10px;border: 1px solid rgba(255,255,255,0.4);">

                                                {{ $prod->quantidade }}x - {{ $prod->produto }}
                                                {{ $prod->marca }} ({{ $prod->peso }})
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 text-nowrap text-light"
                            style="border-radius: 9px;border-width: 2px;border-color: #8c61ff;">
                            <h2 class="text-uppercase text-center text-light" style="margin-bottom: 16px;">Informações</h2>
                            <p>Cliente:<span class="float-end"> {{ $item->nomeCliente }}</span></p>
                            <hr>
                            <p>Forma de Pagamento:<span class="float-end">{{ $item->formaPagamento }}</span></p>
                            <hr>
                            <p>Data:<span class="float-end">{{ $item->created_at }}</span></p>
                            <ul class="list-unstyled"></ul>
                        </div>
                    </div>

                    <div class="modal-footer"
                        style="background: #262626;border-bottom-right-radius: 15px;border-bottom-left-radius: 15px;">
                        <button class="btn btn-outline-light" type="button" data-bs-dismiss="modal">Fechar</button>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                            data-bs-target="#{{ 'mod' . $item->id }}">Cancelar</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach



@endsection


<script src="{{ asset('admin/jquery.js') }}"></script>



<script>
    $(document).ready(function() {
        $('#search-input').on('input', function() {
            var searchValue = $(this).val();

            $.ajax({
                url: '{{ route('filtrar.cliente.relatorio') }}',
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
