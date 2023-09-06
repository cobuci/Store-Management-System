@extends('admin.master.layout')
@section('page-name', $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'))
@section('title', 'Estatisticas')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')


    <form action="/estatisticas" method="GET">
        <div class="row align-items-center">
              
            <div class="col-sm-6 col-md-4">
                <input type="date" name="start_date" id="start_date" class="form-control" type="date" />
            </div>
            <div class="col-sm-6 col-md-4">
                <input type="date" name="end_date" id="end_date" class="form-control" type="date" />
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-dark shadow-sm">Buscar</button>
                <a class="btn btn-danger" onclick="showAlert()">Alertas</a>
            </div>
        </div>
    </form>
  


    <div id="alertas">

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Atenção !</h4>
                    Os Alertas são calculados com base no período informado.
                    <p>É levado em conta a quantidade vendida no período informado. </p>
                </div>
            </div>
        </div>

        @include('admin.master.alertaEstoque')
    </div>


    <div class="row">
        <div class="col-12">
            <div class="font-monospace text-truncate">
                <a class="btn text-start col-12"
                    style="border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;">
                    <span class="float-start" style="margin-right: 10px">
                        <i class="fa fa-history text-center text-white" style="width: 30px; height: 30px"></i>
                    </span>Informações</a>
                <div class=" col-12">
                    <div class="card">
                        <div class="card-body" style="padding: 15px">
                            <h3>Periodo: </h3>
                            <h4> {{ $startDate->format('d/m/Y') }} á {{ $endDate->format('d/m/Y') }}</h4>
                            <h3>Total Custo: </h3>
                            <h4>R$ {{ number_format($totalCusto, 2, ',', '.') }}</h4>
                            <h3>Total Venda: </h3>
                            <h4>R$ {{ number_format($totalVenda, 2, ',', '.') }}</h4>
                            <h3>Lucro: </h3>
                            <h4>R$ {{ number_format($totalLucro, 2, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-flex">
            <div class="w-100">
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
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Produto</th>
                                                        <th>Marca</th>
                                                        <th>Peso</th>
                                                        <th>Qt. Vendida</th>
                                                        <th>Preço Total Custo</th>
                                                        <th>Preço Total Vendido</th>
                                                        <th>Lucro</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dados as $item)
                                                        @foreach ($item as $prod)
                                                            @if (Produto::findProduct($prod->id_produto)->pluck('id_categoria')->implode(', ') == $cat->id)
                                                                <tr>
                                                                    <td>{{ Produto::findProduct($prod->id_produto)->pluck('id')->implode(', ') }}
                                                                    </td>
                                                                    <td>{{ Produto::findProduct($prod->id_produto)->pluck('nome')->implode(', ') }}
                                                                    </td>
                                                                    <td>{{ Produto::findProduct($prod->id_produto)->pluck('marca')->implode(', ') }}
                                                                    </td>
                                                                    <td>{{ Produto::findProduct($prod->id_produto)->pluck('peso')->implode(', ') }}
                                                                    </td>

                                                                    <td>{{ $prod->total_vendas }}</td>

                                                                    <td>R$ {{ $prod->total_custo }}</td>
                                                                    <td>R$ {{ $prod->total_venda }}</td>
                                                                    <td>R$ {{ $prod->total_venda - $prod->total_custo }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
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
            </div>
        </div>
    </div>

    <script>
        const showAlert = () => {
            $("#alertas").toggle();

        }
    </script>
@endsection
