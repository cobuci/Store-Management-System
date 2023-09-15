@extends('admin.master.layout')
@section('page-name', $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'))
@section('title', 'Estatisticas')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"/>
@section('content')

    <form action="/estatisticas" method="GET">
        <div class="row align-items-center">

            <div class="col-sm-6 col-md-4">
                <input type="date" name="start_date" id="start_date" class="form-control" type="date"/>
            </div>
            <div class="col-sm-6 col-md-4">
                <input type="date" name="end_date" id="end_date" class="form-control" type="date"/>
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

        @include('admin.master.alert_inventory')
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
                            <h4>R$ {{ number_format($cost_total, 2, ',', '.') }}</h4>
                            <h3>Total Venda: </h3>
                            <h4>R$ {{ number_format($sale_total, 2, ',', '.') }}</h4>
                            <h3>Lucro: </h3>
                            <h4>R$ {{ number_format($profit_total, 2, ',', '.') }}</h4>
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
                @foreach (Category::show() as $cat)
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
                                                @foreach ($data as $prod)

                                                    @if (Product::findProduct($prod->product_id)->pluck('category_id')->implode(', ') == $cat->id)
                                                        <tr>
                                                            <td>{{ Product::findProduct($prod->product_id)->pluck('id')->implode(', ') }}
                                                            </td>
                                                            <td>{{ Product::findProduct($prod->product_id)->pluck('name')->implode(', ') }}
                                                            </td>
                                                            <td>{{ Product::findProduct($prod->product_id)->pluck('brand')->implode(', ') }}
                                                            </td>
                                                            <td>{{ Product::findProduct($prod->product_id)->pluck('weight')->implode(', ') }}
                                                            </td>

                                                            <td>{{ $prod->total_amount }}</td>

                                                            <td>R$ {{ $prod->total_cost }}</td>
                                                            <td>R$ {{ $prod->total_sale }}</td>
                                                            <td>R$ {{ $prod->total_sale - $prod->total_cost }}
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
            </div>
        </div>
    </div>

    <script>
        const showAlert = () => {
            $("#alertas").toggle();

        }
    </script>
@endsection