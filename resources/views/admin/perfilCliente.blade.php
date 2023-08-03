@extends('admin.master.layout')
@section('title', 'Perfil')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')



    <div class="container">
        <h1 class="text-center text-dark">{{ '#' . $cliente->id . ' - ' . $cliente->nome }}</h1>
        <div class="row" style="margin-top:20px; margin-bottom: 10px;">
            <div class="col-sm-12 col-md-4 col-sm-12" style="margin-bottom: 10px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: rgb(61,61,61);color: rgb(238,238,238);height: 100%;">
                    <div class="card-body shadow-sm">
                        <div style="height: 26em; margin-bottom: 20px;" id="map"></div>
                        {{-- Formulario --}}
                        <form method="post" action=" {{ route('cliente.editar', $cliente->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text"
                                    style="margin-bottom: 10px;width: 60%;margin-right: 10px;background: rgba(255,255,255,0);"
                                    placeholder="Name" name="nome" value="{{ $cliente->nome }}">
                                <input class="form-control text-light" type="text"
                                    style="margin-bottom: 10px;width: 40%;background: rgba(255,255,255,0);"
                                    placeholder="Tel" name="telefone" value="{{ $cliente->telefone }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="email"
                                    style="margin-bottom: 10px;width: 100%;background: rgba(255,255,255,0);"
                                    placeholder="E-mail" name="email" value="{{ $cliente->email }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text" id="cep"
                                    style="margin-bottom: 10px;width: 30%;background: rgba(255,255,255,0);margin-right: 10px;"
                                    placeholder="Zip" name="cep" value="{{ $cliente->cep }}">
                                <input class="form-control text-light" type="text" id="rua"
                                    style="margin-bottom: 10px;width: 70%;background: rgba(255,255,255,0);"
                                    placeholder="Address" name="rua" value="{{ $cliente->rua }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text"
                                    style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);margin-right: 10px;"
                                    placeholder="N / AP" name="numero" value="{{ $cliente->numero }}">
                                <input class="form-control text-light" type="text" id="bairro"
                                    style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);"
                                    placeholder="Bairro" name="bairro" value="{{ $cliente->bairro }}">
                            </div>
                            <div class="d-xl-flex d-xxl-flex justify-content-xl-end justify-content-xxl-end">

                                <button class="btn btn-outline-danger shadow-sm" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modalApagar" style="border-radius: 10px;margin-right: 15px;"
                                    title="Deletar cliente">Apagar</button>


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
                                    <div class="col"><span class="fs-3">Debit Balance</span></div>
                                    <div class="col-auto text-light"><i class="material-icons fs-1">attach_money</i></div>
                                </div>
                                <h6 class="fs-4 text-light card-subtitle mb-2">R$ {{ $totalDebit }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                            style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 100px;">
                                <div class="row">
                                    <div class="col"><span class="fs-3">Total Spent</span></div>
                                    <div class="col-auto text-end"><i class="material-icons fs-1">attach_money</i></div>
                                </div>
                                <h6 class="fs-4 text-light card-subtitle mb-2">R$ {{ $totalSpent }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                            style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 100px;">
                                <div class="row">
                                    <div class="col"><span class="fs-3 mb-5">Águas Compradas<br></span>
                                    </div>
                                    <div class="col-auto text-light"><i class="fas fa-glass-whiskey fs-1"></i></div>
                                </div>
                                <h6 class="fs-4 text-light card-subtitle mb-3">
                                    {{ Cliente::quantidadeAgua($cliente->id) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card"
                            style="height: 32em;width: 100%;background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
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

    {{-- Modal Apagar Cliente --}}
    <div class="modal fade" tabindex="-1" id="modalApagar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                <div class="modal-header text-light"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                    <h4 class="modal-title  text-light">
                        Confirmar exclusão
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-monospace" style="background: #3d3d3d;">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 text-nowrap text-light"
                                style="border-radius: 9px;padding-top: 15px;border-width: 2px;border-color: #8c61ff;">
                                <p>
                                    Nome: {{ $cliente->nome }}
                                </p>
                                <p>
                                    Débito total: R$ {{ $totalDebit }}
                                </p>
                                <p>
                                    Total Gasto: R$ {{ $totalSpent }}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('cliente.destroy', $cliente->id) }}">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
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

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: @json($apiGoogle),
            v: "beta"
        });
    </script>



    @php
        
    @endphp

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script>
        // Initialize and add the map
        let map;                  
      
        async function initMap() {

            const position = {
                lat: @json($latitude),
                lng: @json($longitude)
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerView
            } = await google.maps.importLibrary("marker");

          
            map = new Map(document.getElementById("map"), {
                zoom: 16,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerView({
                map: map,
                position: position,               
            });
        }

        initMap();
    </script>
@endsection
