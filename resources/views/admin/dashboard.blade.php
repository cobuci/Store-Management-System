@extends('admin.master.layout')
@section('title', 'Dashboard')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
@section('content')
    <div class="row">
        <div class="d-flex">
            <div class="w-100">
                <div class="row">
                    <!-- Balance Revenue -->
                    <div class="col-md-4">
                        <div class="card" style="height: 90%">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Balance</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">R$ {{ Caixa::saldo() }}</h1>
                                <br>
                                <div class="mb-0">
                                    <p class="text-muted"> Daily average ({{ Dashboard::checkMonth(Dashboard::month(1)) }})
                                        : R$ {{ Dashboard::dailyAvg() }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Daily Income -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Daily Income</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3 ">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-auto">R$ {{ Dashboard::salesToday(1) }}</div> <span
                                            class="text-success"> R$ {{ Dashboard::profit() }}
                                        </span>
                                    </div>
                                </h1>
                                <div class="mb-0">
                                    <span
                                        class=" {{ Dashboard::percentDailySales() > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ Dashboard::percentDailySales() }} %
                                    </span>
                                    <p class="text-muted"> Last day: R$ {{ Dashboard::salesToday(2) }}
                                        <span class="text-success"> (R$ {{ Dashboard::profit(2) }} )
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Revenue -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Monthly Revenue</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-auto">R$
                                            {{ Dashboard::salesMonth() }}
                                        </div>
                                        <span class="text-success">
                                            R$ {{ Dashboard::profitMonth() }}
                                        </span>
                                    </div>
                                </h1>
                                <div class="mb-0">
                                    <span
                                        class="{{ Dashboard::porcentagemVendasMensais() > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ Dashboard::porcentagemVendasMensais() }} %
                                    </span>
                                    <p class="text-muted"> Last month: R$
                                        {{ Dashboard::salesMonth(2) }}
                                        <span class="text-success"> (R$
                                            {{ Dashboard::profitMonth(2) }})
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Meta -->
                    <div class="col-md-12">
                        <div class="card" type="button" data-bs-toggle="modal" data-bs-target="#definirMeta">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title"> Monthly goal </h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">R$ {{ Dashboard::salesMonth() }} / R$ {{ Dashboard::monthGoal() }}
                                </h1>
                                <div class="progress" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                    aria-valuemax="100"style="height: 50px">
                                    <div class="progress-bar bg-danger" style="width: {{ Dashboard::goalPercentage() }}%">
                                        {{ Dashboard::goalPercentage() }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Definir meta -->
    <div class="modal fade" id="definirMeta" tabindex="-1" aria-labelledby="definirMeta" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="definirMeta">Definir Meta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/dashboard/meta">
                        @csrf
                        <b>Meta: </b>
                        <p></p>
                        <input type="number" class="form-control" type="text" id="valor" name="valor" required
                            step="any" style="background: rgba(255, 255, 255, 0);border-radius: 10px;"
                            placeholder="Valor" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Definir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- CHART --}}
    <div class="row">
        <div class="">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Movement</h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas id="chartjs-dashboard-line"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- DADOS --}}
    @for ($i = $monthsChart; $i > 0; $i--)
        <input type="hidden" id="{{ 'hiddeninput' . $i }}"
            value="{{ Dashboard::checkMonth(Dashboard::month($i)) }}" />

        <input type="hidden" id="{{ 'hiddeninputValue' . $i }}" value="{{ Dashboard::salesMonth($i) }}" />

        <input type="hidden" id="{{ 'hiddeninputProfit' . $i }}" value="{{ Dashboard::profitMonth($i) }}" />
    @endfor

@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document
            .getElementById("chartjs-dashboard-line")
            .getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 1)");    

        const labels = [];
        const valores = [];
        const profit = [];
        for (var i = {{ $monthsChart }}; i > 0; i--) {
            labels.push(document.getElementById('hiddeninput' + i).value);
            valores.push(document.getElementById('hiddeninputValue' + i).value);
            profit.push(document.getElementById('hiddeninputProfit' + i).value);
        }
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                        label: "Vendas (R$)",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.primary,
                        data: valores,
                    },
                    {

                        label: "Lucro (R$)",
                        fill: true,
                        backgroundColor: "gradient",
                        borderColor: "rgba(0, 147, 14, 1)",
                        data: profit,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                },
                hover: {
                    intersect: true,
                },
                plugins: {
                    filler: {
                        propagate: false,
                    },
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)",
                        },
                    }, ],
                    yAxes: [{
                        display: true,
                        borderDash: [33, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.3)",
                        },
                    }, ],
                },

            },
        });
    });
</script>
