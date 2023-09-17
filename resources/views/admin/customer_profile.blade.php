@extends('admin.master.layout')
@section('title', 'Perfil')

@section('content')

    <div class="container">
        <h1 class="text-center text-dark">{{ '#' . $customer->id . ' - ' . $customer->name }}</h1>
        <div class="row" style="margin-top:20px; margin-bottom: 10px;">
            <div class="col-sm-12 col-md-4 col-sm-12" style="margin-bottom: 10px;">
                <div class="card col-md-12 col-sm-12"
                     style="border-radius: 22px;background: rgb(61,61,61);color: rgb(238,238,238);height: 100%;">
                    <div class="card-body shadow-sm">
                        <div style="height: 26em; margin-bottom: 20px;" id="map"></div>
                        {{-- Formulario --}}
                        <form method="post" action=" {{ route('customer.edit', $customer->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text"
                                       style="margin-bottom: 10px;width: 60%;margin-right: 10px;background: rgba(255,255,255,0);"
                                       placeholder="Name" name="name" value="{{ $customer->name }}">
                                <input class="form-control text-light" type="text"
                                       style="margin-bottom: 10px;width: 40%;background: rgba(255,255,255,0);"
                                       placeholder="Tel" name="phone" value="{{ $customer->phone }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="email"
                                       style="margin-bottom: 10px;width: 100%;background: rgba(255,255,255,0);"
                                       placeholder="E-mail" name="email" value="{{ $customer->email }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text" id="zipcode"
                                       style="margin-bottom: 10px;width: 30%;background: rgba(255,255,255,0);margin-right: 10px;"
                                       placeholder="Zip" name="zipcode" value="{{ $customer->zipcode }}">
                                <input class="form-control text-light" type="text" id="street"
                                       style="margin-bottom: 10px;width: 70%;background: rgba(255,255,255,0);"
                                       placeholder="Address" name="street" value="{{ $customer->street }}">
                            </div>
                            <div class="col-12 d-flex d-xxl-flex justify-content-center justify-content-xxl-center">
                                <input class="form-control text-light" type="text"
                                       style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);margin-right: 10px;"
                                       placeholder="N / AP" name="number" value="{{ $customer->number }}">
                                <input class="form-control text-light" type="text" id="district"
                                       style="margin-bottom: 10px;width: 50%;background: rgba(255,255,255,0);"
                                       placeholder="Bairro" name="district" value="{{ $customer->district }}">
                            </div>
                            <div class="d-xl-flex d-xxl-flex justify-content-xl-end justify-content-xxl-end">

                                <button class="btn btn-outline-danger shadow-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalApagar" style="border-radius: 10px;margin-right: 15px;"
                                        title="Deletar customer">Apagar
                                </button>


                                <button class="btn btn-outline-light shadow-sm" data-bs-toggle="tooltip"
                                        data-bss-tooltip=""
                                        data-bs-placement="bottom" type="submit" style="border-radius: 10px;"
                                        title="Salvar alterações">Salvar
                                </button>
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
                            <div class="card-body" style="height: 10em;">
                                <div class="row">
                                    <div class="col">
                                        <span class="fs-3">A pagar</span>
                                    </div>
                                    <div class="col-auto text-light">
                                        <i class="fas fa-hand-holding-dollar fs-1"></i></div>
                                </div>
                                <div class="row">
                                    <h6 class="fs-4 text-light  mb-2 ">R$ {{ $totalDebit }}</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                             style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 10em;">
                                <div class="row">
                                    <div class="col">
                                        <span class="fs-3">Total gasto</span>
                                    </div>
                                    <div class="col-auto text-light">
                                        <i class="fas fa-money-bill-trend-up fs-1"></i></div>
                                </div>
                                <div class="row">
                                    <h6 class="fs-4 text-light  mb-2 ">R$ {{ $totalSpent }}</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4" style="margin-bottom: 10px;">
                        <div class="card"
                             style="background: rgb(61,61,61);color: var(--bs-gray-200);border-radius: 10px;">
                            <div class="card-body" style="height: 10em;">
                                <div class="row">
                                    <div class="col">
                                        <span class="fs-4 mb-5">Águas Compradas</span>
                                    </div>
                                    <div class="col-auto text-light">
                                        <i class="fas fa-glass-whiskey fs-1"></i>
                                    </div>
                                </div>
                                <h6 class="fs-4 text-light card-subtitle mb-3">
                                    {{ $water_amount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="font-monospace text-truncate">
                            <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="false"
                               aria-controls="collapse-1" href="#collapse-1" role="button"
                               style="border-radius: 10px 10px 0 0;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;"><span
                                    class="float-end">
                                    <i class="fa fa-chevron-down text-white"></i>
                                </span>
                                <span class="float-start" style="margin-right: 10px;">
                                    <i class="fa fa-history text-center text-white"
                                       style="width: 30px;height: 30px;"></i>
                                </span>A Pagar
                            </a>
                        </div>
                        <div class="collapse col-md-12" id="collapse-1">
                            <div class="card ">
                                <div class="card-body" style="padding: 0;">

                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-bordered tabela-data">
                                            <thead class="text-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Valor (Custo)</th>
                                                <th>Valor (Venda)</th>
                                                <th>Data</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-truncate text-dark ">
                                            @foreach ($all_purchases as $order)
                                                @if ($order->payment_status == 0)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->cost }}<br></td>
                                                        <td>{{ $order->price }}<br></td>
                                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/yy') }}
                                                            <br>
                                                        <td class="text-center">
                                                            <form method="post"
                                                                  action="{{ route('order.status', $order->id) }}">

                                                                @csrf
                                                                <button class="btn btn-outline-primary" type="button"
                                                                        style="margin-right: 10px;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#{{ 'modDetail' . $order->id }}">
                                                                    Detalhes
                                                                </button>

                                                                <button class="btn btn-outline-success" type="submit"
                                                                        style="margin-right: 10px;width: 50%;">Confirmar
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="font-monospace text-truncate">
                            <a class="btn text-start col-12" data-bs-toggle="collapse" aria-expanded="true"
                               aria-controls="collapse-2" href="#collapse-2" role="button"
                               style="border-radius: 0;background: #3d3d3d;color: var(--bs-white);font-weight: bold;font-size: 20px;"><span
                                    class="float-end">
                                    <i class="fa fa-chevron-down text-white"></i>
                                </span>
                                <span class="float-start" style="margin-right: 10px;"><i
                                        class="fa fa-check text-center text-white"
                                        style="width: 30px;height: 30px;"></i>
                                </span>Pago
                            </a>
                            <div class="collapse show col-md-12" id="collapse-2">
                                <div class="card">
                                    <div class="card-body " style="padding: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead class="text-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Valor (Custo)</th>
                                                    <th>Valor (Venda)</th>
                                                    <th>Lucro</th>
                                                    <th>Data</th>

                                                </tr>
                                                </thead>
                                                <tbody class="text-truncate text-dark">
                                                @foreach ($all_purchases as $order)
                                                    @if ($order->payment_status == 1)
                                                        <tr>
                                                            <td>{{ $order->id }}</td>
                                                            <td>{{ $order->cost }}<br></td>
                                                            <td>{{ $order->price }}<br></td>
                                                            <td>R$ {{ $order->price - $order->cost }}<br></td>
                                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/yy') }}
                                                                <br>
                                                            <td class="text-center">
                                                                <button class="btn btn-outline-primary" type="button"
                                                                        style="margin-right: 10px;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#{{ 'modDetail' . $order->id }}">
                                                                    Detalhes
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
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


            @foreach ($all_purchases as $item)
                <div class="modal fade" id="{{ 'mod' . $item->id }}" tabindex="-1"
                     aria-labelledby="{{ 'mod' . $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{ 'mod' . $item->id }}">Cancelar Venda
                                    #{{ $item->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <br>
                                Preço: R${{ $item->price }}
                                <br>
                                Cliente: {{ $item->customer_name }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form method="POST" action="{{ route('order.destroy', $item->id) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" tabindex="-1" id="{{ 'modDetail' . $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content"
                             style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                            <div class="modal-header text-light"
                                 style="border-top-left-radius: 15px;border-top-right-radius: 15px;background: #262626;">
                                <h4 class="modal-title  text-light">#{{ $item->id }}</h4>
                                <button type="button"
                                        class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body font-monospace" style="background: #3d3d3d;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-md-12 text-nowrap text-light"
                                             style="border-radius: 9px;padding-top: 15px;border-width: 2px;border-color: #8c61ff;">
                                            <h2 class="text-uppercase text-center text-light"
                                                style="margin-bottom: 16px;">Valores
                                            </h2>
                                            <p>
                                                <span class="float-end">
                                                    R$ {{ $item->cost }}
                                                </span>
                                                Custo:
                                            </p>
                                            <hr>
                                            <p>
                                                Desconto:
                                                <span class="float-end">
                                                    R$ {{ $item->discount == null ? '0.00' : $item->discount }}
                                                </span>
                                            </p>
                                            <hr>
                                            <p>
                                                Venda:
                                                <span class="float-end">
                                                    R$ {{ $item->price }}
                                                </span>
                                            </p>
                                            <hr>
                                            <p>
                                                Lucro:
                                                <span class="float-end">
                                                    R$ {{ $item->price - $item->cost }}
                                                </span>
                                            </p>
                                            <hr>
                                            <ul class="item-unstyled"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-md-12 text-nowrap text-light"
                                             style="border-radius: 0 0 9px 9px;border-width: 2px;border-color: #8c61ff;">
                                            <h2 class="text-uppercase text-center  text-light"
                                                style="margin-bottom: 16px;">
                                                Produtos
                                            </h2>
                                            <ul class="item-unstyled">
                                                @foreach (Order::findOrder($item->order_id) as $prod)
                                                    <li
                                                        style="background: rgba(255,255,255,0.1);border-radius: 11px;padding-right: 3px;padding-left: 15px;margin-bottom: 10px;border: 1px solid rgba(255,255,255,0.4);">

                                                        {{ $prod->amount }}x - {{ $prod->product_name }}
                                                        {{ $prod->product_brand }} ({{ $prod->weight }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 text-nowrap text-light"
                                     style="border-radius: 9px;border-width: 2px;border-color: #8c61ff;">
                                    <h2 class="text-uppercase text-center text-light" style="margin-bottom: 16px;">
                                        Informações
                                    </h2>
                                    <p>Cliente:<span class="float-end"> {{ $item->customer_name }}</span></p>
                                    <hr>
                                    <p>Forma de Pagamento:<span class="float-end">{{ $item->payment_method }}</span></p>
                                    <hr>
                                    <p>Data:<span class="float-end">{{ $item->created_at }}</span></p>
                                    <ul class="item-unstyled"></ul>
                                </div>
                            </div>

                            <div class="modal-footer"
                                 style="background: #262626;border-bottom-right-radius: 15px;border-bottom-left-radius: 15px;">
                                <div class="ms-auto">
                                    <a href="{{ route('invoice', $item->id) }}" class="btn btn-outline-primary"
                                       type="button">Recibo</a>
                                </div>
                                <button class="btn btn-outline-light" type="button"
                                        data-bs-dismiss="modal">Fechar
                                </button>
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                        data-bs-target="#{{ 'mod' . $item->id }}">Cancelar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach



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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body font-monospace" style="background: #3d3d3d;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-12 text-nowrap text-light"
                                         style="border-radius: 9px;padding-top: 15px;border-width: 2px;border-color: #8c61ff;">
                                        <p>
                                            Nome: {{ $customer->name }}
                                        </p>
                                        <p>
                                            A pagar: R$ {{ $totalDebit }}
                                        </p>
                                        <p>
                                            Total Gasto: R$ {{ $totalSpent }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('customer.destroy', $customer->id) }}">
                                @method('DELETE')
                                @csrf
                                <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar
                                </button>
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script type="module">
                $(document).ready(function () {
                    function cleanFormZip() {

                        $("#street").val("");
                        $("#district").val("");
                    }

                    //Quando o campo cep perde o foco.
                    $("#zipcode").blur(function () {
                        const zip = $(this).val().replace(/\D/g, '');
                        if (zip !== "") {
                            const validacep = /^[0-9]{8}$/;
                            if (validacep.test(zip)) {
                                $("#street").val("...");
                                $("#district").val("...");

                                $.getJSON("https://viacep.com.br/ws/" + zip + "/json/?callback=?", function (data) {
                                    if (!("erro" in data)) {

                                        $("#street").val(data.logradouro);
                                        $("#district").val(data.bairro);
                                    } else {
                                        cleanFormZip();
                                        alert("CEP não encontrado.");
                                    }
                                });
                            } else {
                                cleanFormZip();
                                alert("Formato de CEP inválido.");
                            }
                        } //end if.
                        else {
                            cleanFormZip();
                        }
                    });
                });
            </script>

            <script>
                (g => {
                    let h, a, k, p = "The Google Maps JavaScript API",
                        c = "google",
                        l = "importLibrary",
                        q = "__ib__",
                        m = document,
                        b = window;
                    b = b[c] || (b[c] = {});
                    const d = b.maps || (b.maps = {}),
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

                    const marker = new AdvancedMarkerView({
                        map: map,
                        position: position,
                    });
                }

                initMap();
            </script>
@endsection
