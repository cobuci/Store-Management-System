@extends('admin.master.layout')
@section('title', 'Clientes')
@section('content')
    <div class="container">
        <h1 class="text-center text-light">Clientes</h1>

        <div class="row" style="margin-bottom: 10px">
            @foreach ($clientes as $cliente)
                <div class="col-md-4 col-sm-12" style="margin-bottom: 10px">
                    <div class="card col-12"
                        style="border-radius: 22px;background: rgb(61, 61, 61); color: rgb(238, 238, 238);">
                        <div class="card-body shadow-sm">
                            <h4 class="card-title"># {{ $cliente->id }} - {{ $cliente->nome }}<br /></h4>
                            <p class="card-text">
                                {{ $cliente->rua }} , {{ $cliente->numero }} - SP<br />
                            </p>
                            <div class="d-xl-flex d-xxl-flex justify-content-xl-end justify-content-xxl-end">

                                <a href="{{ route('admin.cliente.perfil', $cliente->id)}}" class="btn btn-outline-light shadow-sm" data-bs-toggle="tooltip" data-bss-tooltip=""
                                    data-bs-placement="bottom" type="submit" style="border-radius: 10px" title="Verificar">
                                    Verificar
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    </div>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col">
                <nav class="border rounded-pill shadow d-xl-flex justify-content-center align-items-center align-content-center align-self-center justify-content-xl-center align-items-xl-center"
                    style="background: rgba(248, 249, 250, 0.21)">
                    <ul class="pagination">
                        {{ $clientes->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
