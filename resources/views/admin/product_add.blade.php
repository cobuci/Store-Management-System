@extends('admin.master.layout')
@section('title', 'Entrada Produto')
@section('page-name', 'Entrada Produto')
@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 10px; margin-top: 20px">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                     style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                         style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        <form id="personForm" name="personForm" method="POST" action="/entradaestoque"
                              data-url="{{ route('load_prod_cat') }}">
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86); margin-bottom: 10px">Dados
                            </h4>
                            <label for="category_id">Categoria</label>
                            <select class="form-select text-light bg-dark"
                                    id="category_id" name="category_id"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);">
                                <optgroup label="Categoria">
                                    <option disabled selected value=""> Categoria</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <label for="product">Produto</label>
                            <select class="form-select text-light bg-dark" id="product" name="product"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color: rgb(0, 0, 0);">
                                <optgroup label="Produto">
                                    <option disabled selected value="">Produto</option>
                                </optgroup>
                            </select>
                            <label for="amount">Quantidade</label>
                            <input class="form-control" type="text" id="amount" required=""
                                   onkeyup="insere(),changeTotalValue()" placeholder="Quantidade (*)"
                                   name="amount"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="expiration_date">Validade</label>
                            <input class="form-control" id="expiration_date" type="date"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-gray-300);border-radius: 10px;border-color: var(--bs-gray-600);"
                                   name="expiration_date"/>
                            <h4 class="text-center"
                                style="color: rgba(246, 247, 248, 0.86);margin-top: 10px;margin-bottom: 10px;">
                                Valores
                            </h4>
                            <label for="cost">Custo Unitario</label>
                            <input class="form-control" type="text" id="cost" required=""
                                   onkeyup="insere(),changeTotalValue()" placeholder="Custo Unitário (*)" name="cost"
                                   style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="cost_total">Custo Total</label>
                            <input class="form-control" type="text" id="cost_total" required=""
                                   onkeyup="insere(),changeUnitValue()" placeholder="Custo Total" name="cost_total"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="sale">Valor de venda</label>
                            <input class="form-control" type="text" id="sale" onkeyup="insere()"
                                   placeholder="Valor de Venda" name="sale"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <p class="font-monospace text-center" id="profit"></p>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio1"
                                           name="radio"/><label class="form-check-label" for="formCheck-1">25%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio2"
                                           name="radio"/><label class="form-check-label" for="formCheck-2">50%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio3"
                                           name="radio"/>
                                    <label class="form-check-label" for="formCheck-3">75%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio4"
                                           name="radio"/><label class="form-check-label" for="formCheck-4">90%</label>
                                </div>
                            </div>
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px; margin-top: 10px" title="Cadastrar">Adicionar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#category_id").change(function () {
                const url = $('#personForm').attr("data-url");
                categoria = $(this).val();
                $.ajax({
                    url: url,
                    data: {
                        'categoria': categoria,
                    },
                    success: function (data) {
                        $("#product").html(data);
                    }
                });
            });
        });
    </script>
@endsection