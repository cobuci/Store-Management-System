@extends('admin.master.layout')
@section('title', 'Lista de Compras')
@section('page-name', 'Lista de Compras')
@section('content')
    <div class="container">
        <h1 class="text-center text-light">Lista de Compras</h1>
        <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
            <div class="col-sm-12 col-md-8 offset-md-2" style="border-style: none;">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                        <form method="post" action="/shoppingList/add">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control" type="text" id="quantidadeEntrada" required=""
                                        placeholder="Produto" name="produto"
                                        style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <input class="form-control" type="text" id="quantidadeEntrada-2" required=""
                                        placeholder="Quantidade (*)" name="quantidade"
                                        style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);"
                                        inputmode="numeric">
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <input class="form-control" type="text" id="quantidadeEntrada-1" required=""
                                        placeholder="Valor (un.)" name="custo"
                                        style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);"
                                        inputmode="numeric">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                        data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                        style="border-radius: 10px;margin-bottom: 10px" title="Cadastrar">Adicionar</button>
                                </div>
                            </div>
                        </form>
                        @foreach ($lista as $list)
                            <div class="row">

                                <div class="col"
                                    style="padding-top: 1px;padding-bottom: 1px;margin-right: 12px;margin-left: 12px;">
                                    <ul class="list-unstyled">
                                        <li
                                            style="background: rgba(255,255,255,0.1);border-radius: 11px;padding-right: 3px;padding-left: 15px;border: 1px solid rgba(255,255,255,0.4);">
                                            <span class="float-end" style="margin-right: 10px;">
                                                <form method="POST" action="{{ route('order.shop.destroy', $list->id) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn fa fa-remove text-danger" type="submit">
                                                                                            </button>

                                                </form>
                                            </span> {{ $list->quantidade }} - {{ $list->produto }} - R$ {{ $list->custo }}
                                            (un.)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <div class="row" style="margin-top: 10px;">
                            <div class="col">
                                <div>
                                    <span class="font-monospace d-inline float-end">R$ {{ $total }}</span>
                                    <span class="font-monospace d-inline float-end">Total:&nbsp;</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection
