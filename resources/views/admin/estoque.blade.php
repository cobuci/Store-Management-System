@extends('admin.master.layout')
@section('title', 'Estoque')
@section('page-name', 'Estoque')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"/>
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
            <div class="col"
                 style="background: #3d3d3d;border-top-right-radius: 10px;border-bottom-right-radius: 10px;">
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
                                <table class="table table-borderless">
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
                                    @foreach (Product::listarUltimos() as $product)
                                        <tr style="background: {{ $product->amount <= 0 ? 'indianred' : null }};">
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->brand }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td>{{ $product->cost }}</td>
                                            <td>{{ $product->sale }}</td>
                                            <td>{{ $product->amount }}</td>
                                            <td>{{ $product->expiration_date }}</td>
                                            <td>
                                                <button class="btn btn-outline-primary col-12" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_edit{{ $product->id }}">
                                                    Editar
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-danger col-12" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#apagarProduto{{ $product->id }}">
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
    @foreach (Category::listar() as $cat)
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
                                    @foreach (Product::listar() as $product)
                                        @if ($product->category_id == $cat->id)
                                            <tr style="background: {{ $product->amount <= 0 ? '#eb6363' : null }};">
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->brand }}</td>
                                                <td>{{ $product->weight }}</td>
                                                <td>{{ $product->cost }}</td>
                                                <td>{{ $product->sale }}</td>
                                                <td>{{ $product->amount }}</td>
                                                <td>{{ $product->expiration_date }}</td>
                                                <td>
                                                    <button class="btn btn-outline-primary col-12" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal_edit{{ $product->id }}">
                                                        Editar
                                                    </button>

                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-danger col-12" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#apagarProduto{{ $product->id }}">
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
    @foreach (Product::listar() as $product)
        <div class="modal fade" id="apagarProduto{{ $product->id }}" tabindex="-1"
             aria-labelledby="apagarProduto{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="apagarProduto{{ $product->id }}">Confirmar exclusão do Produto
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('product.destroy', $product->id) }}">
                            @method('DELETE')
                            @csrf
                            #{{ $product->id }} - {{ $product->name }} - {{ $product->brand }} -
                            {{ $product->weight }}
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

        <div class="modal fade" tabindex="-1" id="modal_edit{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"
                     style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <div class="modal-header text-light"
                         style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                        <h4 class="modal-title  text-light">
                            Editar Produto {{ '#' . $product->id . ' - ' . $product->name . ' - ' . $product->weight }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body font-monospace" style="background: #3d3d3d;">
                        <div class="container">
                            <div class="row">
                                <form method="post" action=" {{ route('product.edit', $product->id)}}">
                                    @method('PUT')
                                    @csrf
                                    <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                        Dados
                                    </h4>

                                    <select class="form-select text-light bg-dark" id="category_id"
                                            style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                            name="category_id">
                                        <optgroup label="Categoria">
                                            <option value="{{ $product->category_id }}">Categoria</option>
                                            @foreach (Category::listar() as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input name="id" type="hidden" value="{{ $product->id }}">
                                    <label for="name" class="text-white">Nome do Produto</label>
                                    <input class="form-control" type="text" id="name" placeholder="Nome (*)"
                                           name="name" value="{{ $product->name }}"
                                           style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                                    <label for="brand" class="text-white">Marca do Produto</label>
                                    <input class="form-control" type="text" id="brand" placeholder="Marca"
                                           name="brand" value="{{ $product->brand }}"
                                           style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                           inputmode="tel"/>
                                    <label for="weight" class="text-white">Peso do Produto</label>
                                    <input class="form-control" type="weight" id="peso" placeholder="Unidade (*)"
                                           name="weight"
                                           style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                           inputmode="numeric"/>
                                    <select class="form-select text-light bg-dark" id="weight_type"
                                            style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                            name="weight_type">
                                        <optgroup label="Unidade">
                                            <option value="L">Litros</option>
                                            <option value="ml">Mililitros</option>
                                            <option value="KG">Kg</option>
                                            <option value="g">Gramas</option>
                                            <option value="un">Unidade</option>
                                        </optgroup>
                                    </select>
                                    <label for="amount" class="text-white">Quantidade em estoque</label>
                                    <input class="form-control" type="text" id="amount" required=""
                                           value="{{ $product->amount }}"
                                           placeholder="Quantidade (*)" name="amount"
                                           style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                           inputmode="numeric"/>
                                    <label for="expiration_date" class="text-white">Validade</label>
                                    <input class="form-control" id="expiration_date" type="date"
                                           style="background: rgba(255, 255, 255, 0);color: var(--bs-gray-300);border-radius: 10px;border-color: var(--bs-gray-600);"
                                           name="expiration_date"/>
                                    <h4 class="text-center"
                                        style="color: rgba(246, 247, 248, 0.86);margin-top: 10px;margin-bottom: 10px;">
                                        Valores
                                    </h4>
                                    <label for="cost" class="text-white">Custo</label>
                                    <input class="form-control" type="text" id="cost" required=""
                                           value="{{ $product->cost }}"
                                           placeholder="Custo Unitário (*)" name="cost"
                                           style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                           inputmode="numeric"/>
                                    <label for="sale" class="text-white">Valor de Venda</label>
                                    <input class="form-control" type="text" id="sale"
                                           value="{{ $product->sale }}" placeholder="Valor de Venda" name="sale"
                                           style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                           inputmode="numeric"/>
                                    <a class="btn btn-outline-danger shadow-sm float-end" data-bs-dismiss="modal"
                                       style="border-radius: 10px; margin-top: 10px; margin-left:10px">
                                        Cancelar
                                    </a>
                                    <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                            data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                            style="border-radius: 10px; margin-top: 10px" title="editar">
                                        Editar
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
