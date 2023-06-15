@extends('admin.master.layout')
@section('title', 'Finanças')
@section('page-name', 'Finanças')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')


    <div class="row" style="margin-bottom: 10px;">

        <div class="col-sm-12 col-md-4 col-sm-12" style="margin-top: 20px">
            <div class="card col-md-12 col-sm-12 btn" data-bs-toggle="modal" data-bs-target="#modalSaldo"
                style="border-radius: 22px;background: {{ $saldo <= 0 ? '#9e2828' : '#006b54' }};color: rgb(238, 238, 238);">
                <div class="card-body text-center shadow-sm" style="height: 100px">
                    <h4 class="card-title">Saldo</h4>
                    <h3 class="text-light">R$ {{ $saldo }}</h3>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-4 col-sm-12" style="margin-top: 20px">
            <div class="card col-md-12 col-sm-12"
                style="border-radius: 22px;background: {{ $investimento <= 0 ? '#9e2828' : '#006b54' }} ;color: rgb(238, 238, 238);">
                <div class="card-body text-center shadow-sm" style="height: 100px">
                    <h4 class="card-title">Investimento<br /></h4>
                    <h3 class="text-light">R$ {{ $investimento }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="padding-right: 16px; padding-left: 16px">
        <div class="col-12" style="background: rgba(255, 255, 255, 0.7);color: var(--bs-gray-900);border-radius: 10px;">
            <div class="table-responsive ">
                <table class="table table-sm table-striped table-bordered table-hover">
                    <thead class="text-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 20%">Tipo</th>
                            <th colspan="1" style="width: 10%">Valor</th>
                            <th style="width: 50%">Descrição</th>
                            <th colspan="1" style="width: 10%">Data</th>
                            <th colspan="1" style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody class="text-truncate text-dark">
                        @foreach ($financas as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tipo }}</td>
                                <td>
                                    <span class=" {{ $item->tipo == 'ENTRADA' ? 'badge bg-success' : 'badge bg-danger' }} ">
                                        R$ {{ $item->valor }}
                                    </span>
                                </td>
                                <td>{{ $item->descricao }}<br /></td>
                                <td>{{ $item->data }}</td>
                                <td class="text-end">

                                    @if ($item->tipo != 'ENTRADA' && $item->tipo != 'ESTORNO' && $item->tipo != 'CANCELAMENTO')
                                        <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal"
                                            data-bs-target="#{{ 'mod' . $item->id }}">
                                            Cancelar
                                        </button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="" style="margin-top: 20px">
        <div class="row">
            <div class="col-12">
                {{ $financas->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Cancelar  -->

    @foreach ($financas as $financa)
        <div class="modal fade" id="{{ 'mod' . $financa->id }}" tabindex="-1"
            aria-labelledby="{{ 'mod' . $financa->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ 'mod' . $financa->id }}">Cancelar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('financa.destroy', $financa->id) }}">
                            @method('DELETE')
                            @csrf
                            #{{ $financa->id }}
                            <p>
                                {{ $financa->descricao }}
                            </p>
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


    <div class="modal fade" tabindex="-1" id="modalSaldo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                <div class="modal-header text-light"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <h4 class="modal-title  text-light">
                        Opções
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-monospace" style="background: #3d3d3d;">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 text-nowrap text-light"
                                style="border-radius: 9px;padding-top: 15px;border-width: 2px;border-color: #8c61ff;">
                                <button class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#modalAdicionar">Adicionar</button>
                                <button class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#modalResgatar">Resgatar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Adicionar Saldo --}}
    <div class="modal fade" tabindex="-1" id="modalAdicionar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                <div class="modal-header text-light"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <h4 class="modal-title  text-light">
                        Adicionar Saldo
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-monospace" style="background: #3d3d3d;">
                    <div class="container">
                        <div class="row">
                            <form method="POST" action="/investimento/adicionar">
                                @csrf
                                <input type="number" class="form-control  text-white" type="text" id="valor"
                                    name="valor" required min="{{ 0.01 }}" step="any"
                                    style="background: rgba(255, 255, 255, 0);border-radius: 10px;" placeholder="Valor" />
                                <input class="form-control  text-white" type="text" id="descricao" name="descricao"
                                    required
                                    style="background: rgba(255, 255, 255, 0);margin-top: 15px;border-radius: 10px;"
                                    placeholder="Descrição" />
                                <input class="form-control" type="date" id="data" name="data" required
                                    style="margin-top: 15px;background: rgba(255, 255, 255, 0);color: var(--bs-white);" />
                                <div class="text-end" style="margin-top: 15px">
                                    <button class="btn btn-primary" type="submit" style="background: var(--bs-green)">
                                        Adicionar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Resgatar Saldo --}}
    <div class="modal fade" tabindex="-1" id="modalResgatar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                <div class="modal-header text-light"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <h4 class="modal-title  text-light">
                        Resgatar Saldo
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-monospace" style="background: #3d3d3d;">
                    <div class="container">
                        <div class="row">
                            <form method="POST" action="/investimento/remover">
                                @csrf
                                <input type="number" class="form-control text-white" type="text" id="valor"
                                    name="valor" required min="{{ $saldo - $saldo + 0.01 }}"
                                    max="{{ $saldo }}" step="any"
                                    style="background: rgba(255, 255, 255, 0);border-radius: 10px;" placeholder="Valor" />
                                <input class="form-control  text-white" type="text" id="descricao" name="descricao"
                                    required
                                    style="background: rgba(255, 255, 255, 0);margin-top: 15px;border-radius: 10px;"
                                    placeholder="Descrição" />
                                <input class="form-control " type="date" id="data" name="data" required
                                    style="margin-top: 15px;background: rgba(255, 255, 255, 0);color: var(--bs-white);" />
                                <div class="text-end" style="margin-top: 15px">
                                    <button class="btn btn-primary" type="submit" style="background: var(--bs-red)">
                                        Resgatar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
