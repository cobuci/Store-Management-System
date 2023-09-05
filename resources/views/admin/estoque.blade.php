@extends('admin.master.layout')
@section('title', 'Estoque')
@section('page-name', 'Estoque')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')


    <div class="" style="margin-bottom: 20px">
        <div class="row row-cols-3 font-monospace fs-6 text-center text-light justify-content-center align-items-center"
            style="height: 50px;margin-top: 20px;background: #3d3d3d;border-radius: 10px;margin-right: 2px;margin-left: 2px;margin-bottom: 10px;">
            <div class="col" style="background: #3d3d3d;border-top-left-radius: 10px;border-bottom-left-radius: 10px;">
                <span>Custo Total: R$ {{ Caixa::valorCusto() }} </span>
            </div>
            <div class="col" style="background: #3d3d3d">
                <span>Venda Total: R$ {{ Caixa::valorVenda() }}</span>
            </div>
            <div class="col" style="background: #3d3d3d;border-top-right-radius: 10px;border-bottom-right-radius: 10px;">
                <span>Lucro Total: R$ {{ Caixa::valorLucro() }}</span>
            </div>
        </div>
    </div>

    {{-- Ultimos Produtos --}}

    <div class="row">
        <div class="col-12">
            <div class="font-monospace text-truncate">
                <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="#collUltimos" href="#collUltimos" role="button"
                    style="border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;">
                    <span class="float-end">
                        <i class="fa fa-chevron-down text-white"></i></span>
                    <span class="float-start" style="margin-right: 10px">
                        <i class="fa fa-history text-center text-white" style="width: 30px; height: 30px"></i>
                    </span>Últimos Produtos Cadastrados</a>
                <div class="collapse col-12" id="collUltimos">
                    <div class="card">
                        <div class="card-body" style="padding: 0px">
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Produto</th>
                                            <th>Marca</th>
                                            <th>Peso</th>
                                            <th>Preço Custo</th>
                                            <th>Preço Venda (LUCRO)</th>
                                            <th>Quantidade</th>
                                            <th>Validade</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Produto::listarUltimos() as $produto)
                                            <tr style="background: {{ $produto->quantidade <= 0 ? 'indianred' : null }};">
                                                <td>{{ $produto->id }}</td>
                                                <td>{{ $produto->nome }}</td>
                                                <td>{{ $produto->marca }}</td>
                                                <td>{{ $produto->peso }}</td>
                                                <td>{{ $produto->custo }}</td>
                                                <td>{{ $produto->venda }}</td>
                                                <td>{{ $produto->quantidade }}</td>
                                                <td>{{ $produto->validade }}</td>
                                                <td>
                                                    <a href="{{ route('admin.produto.editar', $produto->id) }}"
                                                        class="btn btn-outline-primary col-12" type="submit">
                                                        Editar
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-danger col-12" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#apagarProduto{{ $produto->id }}">
                                                        Apagar
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
    </div>

    {{-- LISTAGEM --}}
    @foreach (Categoria::listar() as $cat)
        <div class="col-12 col-sm-12 col-md-12">
            <div class="font-monospace text-truncate">
                <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="#{{ 'key' . $cat->id }}" href="#{{ 'key' . $cat->id }}" role="button"
                    style="border-radius: 0px;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;">
                    <span class="float-end">
                        <i class="fa fa-chevron-down text-white"></i>
                    </span>
                    <span class="float-start" style="margin-right: 10px">
                        <i class="{{ $cat->classe }} text-center text-white"
                            style="width: 30px; height: 30px">{{ $cat->icone }}</i>
                    </span>
                    {{ $cat->nome }}
                </a>
                <div class="collapse col-md-12" id="{{ 'key' . $cat->id }}">
                    <div class="card">
                        <div class="card-body" style="padding: 0px">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Produto</th>
                                            <th>Marca</th>
                                            <th>Peso</th>
                                            <th>Preço Custo</th>
                                            <th>Preço Venda (LUCRO)</th>
                                            <th>Quantidade</th>
                                            <th>Validade</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Produto::listar() as $produto)
                                            @if ($produto->id_categoria == $cat->id)
                                                <tr
                                                    style="background: {{ $produto->quantidade <= 0 ? 'indianred' : null }};">
                                                    <td>{{ $produto->id }}</td>
                                                    <td>{{ $produto->nome }}</td>
                                                    <td>{{ $produto->marca }}</td>
                                                    <td>{{ $produto->peso }}</td>
                                                    <td>{{ $produto->custo }}</td>
                                                    <td>{{ $produto->venda }}</td>
                                                    <td>{{ $produto->quantidade }}</td>
                                                    <td>{{ $produto->validade }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.produto.editar', $produto->id) }}"
                                                            class="btn btn-outline-primary col-12" type="submit">
                                                            Editar
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-danger col-12" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#apagarProduto{{ $produto->id }}">
                                                            Apagar
                                                        </button>
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
    @endforeach

    {{-- FIM LISTAGEM --}}

    <div class="row font-monospace text-center text-light justify-content-center align-items-center"
        style="height: 50px;background: #3d3d3d;border-radius: 2px;margin-right: 1px;margin-left: 1px;margin-bottom: 10px;">

        <div class="col-12" style="background: #3d3d3d">
        </div>

    </div>



    <!-- Modal Apagar -->
    @foreach (Produto::listar() as $produto)
        <div class="modal fade" id="apagarProduto{{ $produto->id }}" tabindex="-1"
            aria-labelledby="apagarProduto{{ $produto->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="apagarProduto{{ $produto->id }}">Confirmar exclusão do Produto
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('produto.destroy', $produto->id) }}">
                            @method('DELETE')
                            @csrf
                            #{{ $produto->id }} - {{ $produto->nome }} - {{ $produto->marca }} -
                            {{ $produto->peso }}
                            <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
