@extends('admin.master.layout')
@section('title', 'Cadastrar Cliente')
@section('page-name', 'Cadastrar Cliente')
@section('content')
    <div class="container">     
        <div class="row" style="margin-bottom: 10px; margin-top: 20px">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        @include('admin.master.alertaErro')
                        <form method="post" action="/cliente/store">
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Dados
                            </h4>
                            <input class="form-control" type="text" id="nome" placeholder="Nome (*)" name="nome"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                            <select class="form-select text-light bg-dark" name="sexo" id="sexo"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color: var(--bs-white);">
                                <optgroup label="Sexo">
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </optgroup>
                            </select>
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Contato
                            </h4>
                            <input class="form-control" type="text" id="telefone" placeholder="Telefone" name="telefone" value="{{ old('telefone')}}"
                                style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="tel" />
                            <input class="form-control" type="text" id="email" placeholder="E-mail" name="email" value="{{ old('email')}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="email" />
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">Endereço</h4>
                            <input class="form-control" type="text" id="cep" placeholder="CEP" name="cep" value="{{ old('cep')}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17); "
                                inputmode="numeric" />
                            <input class="form-control" type="text" id="rua" placeholder="Logradouro" name="rua" value="{{ old('rua')}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                            <input class="form-control" type="text" id="numero" placeholder="Número / AP" name="numero" value="{{ old('numero')}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                            <input class="form-control" type="text" id="bairro" placeholder="Bairro" name="bairro" value="{{ old('bairro')}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                style="border-radius: 10px; margin-top: 10px" title="Cadastrar"> Cadastrar</button>
                        </form>
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
