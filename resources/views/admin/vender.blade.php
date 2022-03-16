@extends('admin.master.layout')
@section('title', 'Vender')
@section('content')

    <div class="container">
        <h1 class="text-center text-light">Registrar Venda</h1>
        <div class="row" style="margin-bottom: 10px; margin-top: 20px">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        @include('admin.master.alertaErro')
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <svg width="24" height="24">
                            </svg>
                            <ul>
                                <li>Não é necessario mudar o campo bonificação.</li>
                                <li>Não é necessario colocar o desconto.</li>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                        </div>
                        <form id="personForm" name="personForm" method="post" action="/vender/loja"
                            data-url="{{ route('load_prod_cat') }}">
                            @csrf
                            <select class="form-select text-light bg-dark" id="categoria"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                name="categoria">
                                <optgroup label="Categoria">
                                    <option disabled selected value="null"> Categoria </option>
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
                            <input class="form-control" type="text" id="quantidade" required="" onkeyup="calcularValor()"
                                placeholder="Quantidade (*)" name="quantidade"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                            <input class="form-control" type="text" id="desconto" onkeyup="calcularValor()"
                                placeholder="Desconto (R$)" name="desconto"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <input class="form-control" type="text" id="valorTotal" required="" placeholder="Valor Total"
                                name="valorTotal"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" readonly="" />
                            <select class="form-select text-light bg-dark" id="cliente"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                name="cliente">
                                <optgroup label="Cliente">
                                    <option value="null"> Cliente </option>
                                    @foreach (Cliente::listar() as $cliente)
                                        <option value="{{ $cliente->id }}">#{{ $cliente->id }} - {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
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
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                style="border-radius: 10px; margin-top: 10px" title="Cadastrar">
                                Vender
                            </button>
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

@endsection
