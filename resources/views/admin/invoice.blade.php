@php use Carbon\Carbon; @endphp
<head>
    <meta charset="utf-8">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>invoice - {{ config("app.name") }} </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin-top: 20px;
            background-color: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id='divToSave' class="card">
                <div class="card-body">
                    <div class="invoice-title">

                        <div class="mb-4">
                            <h2 class="mb-1 text-muted"> {{ config("app.name")}} </h2>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Cliente:</h5>
                                <h5 class="font-size-15 mb-2"> {{ $sale->customer_name }}</h5>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Order No:</h5>
                                    <p># {{ $sale->id }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Data:</h5>
                                    <p> {{ Carbon::parse($sale->created_at)->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="py-2">
                        <h5 class="font-size-15">Resumo da Compra</h5>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Produto</th>
                                    <th>Preço (un.)</th>
                                    <th>Quantidade</th>
                                    <th class="text-end" style="">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <th scope="row">{{ $itemN++ }}</th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">
                                                    {{ ucwords($order->product_name) }}</h5>
                                                <p class="text-muted mb-0">{{ $order->weight }},
                                                    {{ $order->product_brand }}</p>
                                            </div>
                                        </td>
                                        <td>R$ {{ $order->unit_price }}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td class="text-end">R$
                                            {{ $order->amount * $order->unit_price }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">
                                        Desconto :
                                    </th>
                                    <td class="border-0 text-end"> {{ $sale->discount }}</td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">Total:</th>
                                    <td class="border-0 text-end">
                                        <h4 class="m-0 fw-semibold">R$ {{ $sale->price }}</h4>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="float: right; margin-top: 10px;">

        <a class="btn btn-danger" href="{{ url()->previous() }}">Voltar</a>
        <button id="saveButton" class="btn btn-primary">Download</button>

    </div>
</div>


<script type="text/javascript"></script>


</body>

<script>
    document.getElementById("saveButton").addEventListener("click", function () {
        const divToSave = document.getElementById("divToSave");

        // Salva o tamanho original da div
        const originalWidth = divToSave.style.width;
        const originalHeight = divToSave.style.height;

        // Define o tamanho para o modo web (1024x768 pixels)
        divToSave.style.width = "1024px";
        divToSave.style.height = "100%";

        html2canvas(divToSave).then(function (canvas) {
            // Restaura o tamanho original da div
            divToSave.style.width = originalWidth;
            divToSave.style.height = originalHeight;

            // Cria um link para download da imagem
            const link = document.createElement("a");
            link.download = @json($sale->id) +".png";
            link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
            link.click();
        });
    });
</script>

