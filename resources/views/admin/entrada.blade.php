@extends('admin.master.layout')
@section('title', 'Entrada Produto')

@section('content')
    <div class="container">
        <h1 class="text-center text-light">Entrada em Estoque</h1>
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
                            <select class="form-select text-light bg-dark" id="categoria" name="categoria"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);">
                                <optgroup label="Categoria">
                                    <option disabled selected value=""> Categoria </option>
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <select class="form-select text-light bg-dark" id="produto" name="produto"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color: rgb(0, 0, 0);">
                                <optgroup label="Produto">
                                    <option disabled selected value=""> Produto </option>
                                </optgroup>
                            </select>
                            <input class="form-control" type="text" id="quantidade" required=""
                                onkeyup="insere(),calcularValorQuantidade()" placeholder="Quantidade (*)" name="quantidade"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <input class="form-control" id="validade" type="date"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-gray-300);border-radius: 10px;border-color: var(--bs-gray-600);"
                                name="validade" />
                            <h4 class="text-center"
                                style="color: rgba(246, 247, 248, 0.86);margin-top: 10px;margin-bottom: 10px;">
                                Valores
                            </h4>
                            <input class="form-control" type="text" id="custo" required=""
                                onkeyup="insere(),mudarValorTotal()" placeholder="Custo Unitário (*)" name="custo"
                                style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <input class="form-control" type="text" id="valorCustoTotal" required=""
                                onkeyup="insere(),mudarValorUnitario()" placeholder="Custo Total" name="valorCustoTotal"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <input class="form-control" type="text" id="venda" onkeyup="insere()"
                                placeholder="Valor de Venda" name="venda"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <p class="font-monospace text-center" id="lucro"></p>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="valorRadio()" id="radio1"
                                        name="radio" /><label class="form-check-label" for="formCheck-1">25%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="valorRadio()" id="radio2"
                                        name="radio" /><label class="form-check-label" for="formCheck-2">50%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="valorRadio()" id="radio3"
                                        name="radio" />
                                    <label class="form-check-label" for="formCheck-3">75%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="valorRadio()" id="radio4"
                                        name="radio" /><label class="form-check-label" for="formCheck-4">90%</label>
                                </div>
                            </div>
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                style="border-radius: 10px; margin-top: 10px" title="Cadastrar">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script type="text/javascript">
        $(document).ready(function() {
            $("#categoria").change(function() {
                const url = $('#personForm').attr("data-url");
                categoria = $(this).val();
                $.ajax({
                    url: url,
                    data: {
                        'categoria': categoria,
                    },
                    success: function(data) {
                        $("#produto").html(data);
                    }
                });
            });
        });
    </script>
@endsection
