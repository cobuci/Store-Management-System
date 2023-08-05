<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>invoice - Garagem 46</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
        integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted">Garagem 46</h2>
                            </div>                           
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Cliente:</h5>
                                    <h5 class="font-size-15 mb-2"> {{ $sale->nomeCliente }}</h5>                                    
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
                                        <p> {{ \Carbon\Carbon::parse($sale->created_at)->format('d M, Y') }}</p>
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
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $numeroItem++}}</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1"> {{ ucwords($order->produto ) }}</h5>
                                                    <p class="text-muted mb-0">{{ ($order->peso ) }}, {{ ($order->marca ) }}</p>
                                                </div>
                                            </td>
                                            <td>R$ {{ ($order->precoUnidade ) }}</td>
                                            <td>{{ ($order->quantidade ) }}</td>
                                            <td class="text-end">R$ {{ ($order->quantidade * $order->precoUnidade ) }}</td>
                                        </tr>
                                       @endforeach
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Desconto :</th>
                                            <td class="border-0 text-end"> {{ $sale->desconto}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total: </th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">R$ {{ $sale->precoVenda}}</h4>
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
    </div>
   
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>
