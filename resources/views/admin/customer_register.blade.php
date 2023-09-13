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
                        <form method="post" action=" {{ route('admin.customer.store')}}">
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Dados
                            </h4>
                            <label for="name">Nome
                            </label>
                            <input class="form-control" type="text" id="name" placeholder="Nome (*)" name="name"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                            <label for="gender">Sexo</label>
                            <select class="form-select text-light bg-dark" name="gender"
                                    id="gender"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color: var(--bs-white);">
                                <optgroup label="Sexo">
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </optgroup>
                            </select>
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Contato
                            </h4>
                            <label for="phone">Telefone</label>
                            <input class="form-control" type="text" id="phone"
                                   placeholder="Telefone" name="phone"
                                   value="{{ old('phone')}}"
                                   style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="tel"/>
                            <label for="email">E-mail</label>
                            <input class="form-control" type="text" id="email"
                                   placeholder="E-mail" name="email"
                                   value="{{ old('email')}}"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="email"/>
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">Endereço</h4>
                            <label for="zipcode">CEP</label>
                            <input class="form-control" type="text" id="zipcode"
                                   placeholder="CEP" name="zipcode"
                                   value="{{ old('zipcode')}}"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17); "
                                   inputmode="numeric"/>
                            <label for="street">Rua</label>
                            <input class="form-control" type="text" id="street"
                                   placeholder="Logradouro" name="street"
                                   value="{{ old('street')}}"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                            <label for="number">Número</label><input class="form-control" type="text" id="number"
                                                                     placeholder="Número / AP" name="number"
                                                                     value="{{ old('number')}}"
                                                                     style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                            <label for="district">Bairro</label><input class="form-control" type="text" id="district"
                                                                       placeholder="Bairro" name="district"
                                                                       value="{{ old('district')}}"
                                                                       style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                                                       inputmode="numeric"/>
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px; margin-top: 10px" title="Cadastrar"> Cadastrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            function clean_form_zip() {
                $("#street").val("");
                $("#district").val("");
            }

            $("#zipcode").blur(function () {
                const zip = $(this).val().replace(/\D/g, '');
                if (zip !== "") {
                    const validateZip = /^[0-9]{8}$/;
                    if (validateZip.test(zip)) {
                        $("#street").val("...");
                        $("#district").val("...");

                        $.getJSON("https://viacep.com.br/ws/" + zip + "/json/?callback=?", function (data) {
                            if (!("erro" in data)) {
                                $("#street").val(data.logradouro);
                                $("#district").val(data.bairro);
                            } else {
                                clean_form_zip();
                                alert("CEP não encontrado.");
                            }
                        });
                    } else {
                        clean_form_zip();
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    clean_form_zip();
                }
            });
        });
    </script>

@endsection
