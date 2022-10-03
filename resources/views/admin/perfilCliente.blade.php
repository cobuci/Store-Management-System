@extends('admin.master.layout')
@section('title', 'Perfil')
@section('content')



    <div class="container">
        <h1 class="text-center text-light">{{ '#' . $cliente->id . ' - ' . $cliente->nome }}</h1>
        <div class="row" style="margin-top:20px; margin-bottom: 10px;">
            <div class="col-sm-12 col-md-4 col-sm-12" style="margin-bottom: 10px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: rgb(61,61,61);color: rgb(238,238,238);height: 30em;">
                    <div class="card-body shadow-sm">
                        <iframe allowfullscreen="" frameborder="0"
                            src="https://cdn.bootstrapstudio.io/placeholders/map.html" width="100%" height="450"
                            style="width: 100%;height: 200px;">
                        </iframe>
                        {{-- Formulario --}}
                        <form>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control" type="text"
                                    style="margin-bottom: 10px;width: 60%;margin-right: 10px;background: rgba(255,255,255,0);"
                                    placeholder="Name" name="nome" value="{{ $cliente->nome }}">
                                <input class="form-control" type="text"
                                    style="margin-bottom: 10px;width: 40%;background: rgba(255,255,255,0);"
                                    placeholder="Tel" name="telefone" value="{{ $cliente->telefone }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control" type="text"
                                    style="margin-bottom: 10px;width: 100%;background: rgba(255,255,255,0);"
                                    placeholder="E-mail" name="email" value="{{ $cliente->email }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control" type="text" id="cep"
                                    style="margin-bottom: 10px;width: 30%;background: rgba(255,255,255,0);margin-right: 10px;"
                                    placeholder="Zip" name="cep" value="{{ $cliente->cep }}">
                                <input class="form-control" type="text" id="rua"
                                    style="margin-bottom: 10px;width: 70%;background: rgba(255,255,255,0);"
                                    placeholder="Address" name="logradouro" value="{{ $cliente->rua }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control" type="text"
                                    style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);margin-right: 10px;"
                                    placeholder="N / AP" name="numero" value="{{ $cliente->numero }}">
                                <input class="form-control" type="text" id="bairro"
                                    style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);"
                                    placeholder="Bairro" name="bairro" value="{{ $cliente->bairro }}">
                            </div>
                            <div class="d-xl-flex d-xxl-flex justify-content-xl-end justify-content-xxl-end">
                                <button class="btn btn-outline-danger shadow-sm" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px;margin-right: 15px;" title="Deletar cliente">Apagar</button>
                                <button class="btn btn-outline-light shadow-sm" data-bs-toggle="tooltip" data-bss-tooltip=""
                                    data-bs-placement="bottom" type="submit" style="border-radius: 10px;"
                                    title="Salvar alterações">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col" style="width: 100%;">
                <div class="row">
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                            style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 100px;">
                                <div class="row">
                                    <div class="col"><span class="fs-5">Debit Balance</span></div>
                                    <div class="col-auto text-end"><i class="material-icons fs-1">attach_money</i></div>
                                </div>
                                <h6 class="fs-5 text-muted card-subtitle mb-2">R$ {{ $totalDebit }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                            style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 100px;">
                                <div class="row">
                                    <div class="col"><span class="fs-5">Total Spent</span></div>
                                    <div class="col-auto text-end"><i class="material-icons fs-1">attach_money</i></div>
                                </div>
                                <h6 class="fs-5 text-muted card-subtitle mb-2">R$ {{ $totalSpent }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                            style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 100px;">
                                <div class="row">
                                    <div class="col"><span class="fs-5">Águas Compradas<br></span>
                                    </div>
                                    <div class="col-auto text-end"><i class="fas fa-glass-whiskey fs-1"></i></div>
                                </div>
                                <h6 class="fs-5 text-muted card-subtitle mb-2">
                                    {{ Cliente::quantidadeAgua($cliente->id) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card"
                            style="height: 22em;width: 100%;background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body " style="padding: 5px;  height: 100%;">
                                <div class="table-responsive text-start tableFixHead" style=" height: 100%;">
                                    <table class="table table-sm table-hover">
                                        <thead style="color: var(--bs-gray-100); ">
                                            <tr>
                                                <th>#</th>
                                                <th>Produto</th>
                                                <th>Qtd.</th>
                                                <th>Valor (Custo)</th>
                                                <th>Desconto</th>
                                                <th>Valor (Venda)</th>
                                                <th>Lucro</th>
                                                <th>Pagamento</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody style="color: var(--bs-gray-200);">

                                            @foreach (Cliente::comprasCliente($cliente->id) as $compra)
                                                <tr>
                                                    <td>{{ $compra->id }}</td>
                                                    <td>{{ $compra->produto }}</td>
                                                    <td>{{ $compra->quantidade }}</td>
                                                    <td>{{ $compra->custo }}<br></td>
                                                    <td>{{ $compra->desconto }}<br></td>
                                                    <td>{{ $compra->precoVenda }}<br></td>
                                                    <td>{{ Caixa::calcularLucro($compra->precoVenda, $compra->custo) }}<br>
                                                    </td>
                                                    <td>{{ $compra->formaPagamento }}</td>
                                                    <td>{{ $compra->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            <tr></tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
            }
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {
                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {
                        //Preenche os campos com "..." enquanto consulta web service.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        //Consulta o web service viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>

@endsection
