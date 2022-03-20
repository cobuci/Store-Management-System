@extends('admin.master.layout')
@section('title', 'Vender')
@section('content')

    <div class="container">
        <h1 class="text-center text-light">Registrar Venda</h1>
        <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
            <div class="col-sm-12 col-md-8 offset-md-2" style="border-style: none;">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                        <form id="personForm" name="personForm" method="post" action="/vender/loja"
                            data-url="{{ route('load_prod_cat') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-4" style="margin-bottom: 15px;">
                                    <select  class="form-select text-light bg-dark" id="categoria" 
                                        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                        name="categoria">
                                        <optgroup label="Categoria">
                                            <option disabled selected value="null" > Categoria </option>
                                            @foreach (Categoria::listar() as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <select class="form-select text-light bg-dark" id="produto" onchange="calcularValor()"
                                        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                        name="produto">
                                        <optgroup label="Produto">
                                            <option selected disabled value=""> Produto </option>
                                        </optgroup>
                                    </select>


                                    <input class="form-control" type="text" id="quantidade" required=""
                                        onkeyup="calcularValor()" placeholder="Quantidade (*)" name="quantidade"
                                        style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                                    <button class="btn btn-outline-light font-monospace shadow-sm" data-bs-toggle="tooltip"
                                        id="adicionar" data-bss-tooltip="" data-bs-placement="bottom" type=""
                                        style="border-radius: 10px;margin-top: 10px;width: 100%;"
                                        title="Adicionar">Adicionar</button>
                                    <button class="btn btn-outline-light font-monospace shadow-sm" data-bs-toggle="tooltip"
                                        id="remover" data-bss-tooltip="" data-bs-placement="bottom" type=""
                                        style="border-radius: 10px;margin-top: 10px;width: 100%;"
                                        title="Adicionar">Remover</button>
                                </div>
                                <div class="col-sm-12 col-md-5"
                                    style="border-radius: 15px;padding-top: 10px;border: 2px dotted #8c61ff;margin-bottom: 15px;">
                                    <ul class="list-unstyled" id="lista">

                                    </ul>
                                </div>
                                <div class="col-sm-12 col-md-3" style="margin-bottom: 15px;">
                                    <input class="form-control" type="text" id="desconto" onkeyup="calcularValor()"
                                        placeholder="Desconto (R$)" name="desconto"
                                        style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                        inputmode="numeric" />

                                    <input class="form-control" type="text" id="valorTotal" required=""
                                        placeholder="Valor Total" name="valorTotal"
                                        style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                        inputmode="numeric" readonly="" />

                                    <select class="form-select text-light bg-dark" id="pagamento"
                                        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                        name="pagamento">
                                        <optgroup label="Forma de Pagamento">
                                            <option value="Dinheiro">Dinheiro</option>
                                            <option value="PIX">PIX</option>
                                            <option value="Credito">Cartão Crédito</option>
                                            <option value="Debito">Cartão Debito</option>
                                            <option value="Outro">Outro</option>
                                        </optgroup>
                                    </select>

                                    <select class="form-select text-light bg-dark" id="bonificacao"
                                        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                        name="bonificacao">
                                        <optgroup label="Bonificação">
                                            <option value="0">Bonificação</option>
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </optgroup>
                                    </select>
                                    <select class="form-select text-light bg-dark" id="cliente"
                                        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                        name="cliente">
                                        <optgroup label="Cliente">
                                            <option value="null"> Cliente </option>
                                            @foreach (Cliente::listar() as $cliente)
                                                <option value="{{ $cliente->id }}">#{{ $cliente->id }} -
                                                    {{ $cliente->nome }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                        data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                        style="border-radius: 10px; margin-top: 10px" title="Cadastrar">
                                        Vender
                                    </button>
                                </div>
                            </div>

                        </form>
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
        <script>
            const calcularValor = () => {
                let desconto = document.getElementById("desconto").value;
                var produto = document.getElementById('produto');
                var produtoAtual = produto.options[produto.selectedIndex];
                var total = document.getElementById('valorTotal');

                var quantidade = document.getElementById('quantidade').value;
                var valorProduto = produtoAtual.getAttribute("preco");


                if (quantidade && quantidade > 0) {
                    var resultado = (quantidade * valorProduto) - desconto;
                    total.value = resultado.toFixed(2);
                }

            }
        </script>

        <script>
            $(document).ready(function() {
                let row_number = 1;


                let quantidade = $("#quantidade");
                let produto = $("#produto");
               

                $("#adicionar").click(function(e) {
                    e.preventDefault();
                    let precoAttr =  ($("#produto option:selected").attr('preco')) ;
                    let quantAttr =  $("#quantidade").val() ;

                    if (quantidade.val() && produto.val()) {
                        let new_row_number = row_number - 1;
                        $('#product' + row_number)
                            .html($('#product' + new_row_number).html())
                            .find('ul li:first-child');
                        jQuery('<li>', {
                            id: 'product' + row_number,
                            class: 'listaVenda',
                            text: $("#quantidade").val() +
                                " - " +
                                $("#produto option:selected")
                                .attr(
                                    'nome') +
                                " - " +
                                $("#produto option:selected").attr('marca') +
                                " - " +
                                $("#produto option:selected").attr('peso'),
                            produto: $("#produto option:selected").val(),
                            preco: parseFloat(precoAttr) *parseFloat(quantAttr),
                            quantidade:quantAttr,
                        }).appendTo('#lista');
                        row_number++;
                    } else {
                        console.log('oi')
                    }
                });



                $("#remover").click(function(e) {
                    console.log(row_number)
                    e.preventDefault();
                    if (row_number > 1) {
                        $("#product" + (row_number - 1)).remove();
                        row_number--;

                    }
                    console.log(row_number)
                });
            });
        </script>

    @endsection
