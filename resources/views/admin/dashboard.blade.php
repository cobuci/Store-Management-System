@extends('admin.master.layout')
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="margin-bottom: 15px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);">
                    <div class="card-body text-center shadow-sm" style="height: 150px;">
                        <div class="row">
                            <div class="col-9 text-nowrap">
                                <h4 class="text-start" style="font-family: Roboto, sans-serif;color: rgb(171,171,171);">
                                    Balance<br></h4>
                            </div>
                            <div class="col text-truncate text-center">
                                <i class="material-icons fs-1">attach_money</i>
                            </div>
                        </div>
                        <p class="fs-2 text-start card-text">R$ {{ Caixa::saldo() }}<br></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 15px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);height: 100%;">
                    <div class="card-body text-center shadow-sm" style="height: 150px;">
                        <div class="row">
                            <div class="col-9">
                                <h4 class="text-nowrap text-start"
                                    style="font-family: Roboto, sans-serif;color: rgb(171,171,171);">Daily Income

                                </h4>
                            </div>
                            {{-- ICONE --}}
                        </div>
                        <p class="fs-2 text-start card-text" style="margin-bottom: 5px;">R$ {{ Dashboard::salesToday(1) }}
                            <br>
                        </p>
                        <div class="row">
                            <div class="col text-nowrap text-start">
                                <span
                                    class="badge  {{ Dashboard::porcentagemVendasDiaria() > 0 ? 'bg-success' : 'bg-danger' }} ">
                                    <i class="fa {{ Dashboard::porcentagemVendasDiaria() > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"
                                        style="margin-right: 5px;"></i>
                                    {{ Dashboard::porcentagemVendasDiaria() }} %
                                </span>

                                <span class="text-truncate" style="color: var(--bs-gray-500);margin-left: 10px;">
                                    Last day: R$ {{ Dashboard::salesToday(2) }}
                                </span>
                            </div>
                            <div class="col text-end">
                                <span class="text-truncate"
                                    style="color: var(--bs-gray-500);margin-left: 10px;">{{ Dashboard::ultimoDiaVenda() }}<br>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 15px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);height: 100%;">
                    <div class="card-body text-center shadow-sm" style="height: 150px;">
                        <div class="row">
                            <div class="col-9 text-nowrap">
                                <h4 class="text-start" style="font-family: Roboto, sans-serif;color: rgb(171,171,171);">
                                    Monthly Revenue<br>
                                </h4>
                            </div>
                            <div class="col text-truncate">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                    fill="none" class="fs-1">
                                    <path
                                        d="M7 12L10 9L13 12L17 8M8 21L12 17L16 21M3 4H21M4 4H20V16C20 16.5523 19.5523 17 19 17H5C4.44772 17 4 16.5523 4 16V4Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="fs-2 text-start card-text" style="margin-bottom: 5px;">R$ {{ Dashboard::salesMonth() }}
                            <br>
                        </p>
                        <div class="col text-start">
                            <span
                                class="badge {{ Dashboard::porcentagemVendasMensais() > 0 ? 'bg-success' : 'bg-danger' }}">
                                <i class="fa   {{ Dashboard::porcentagemVendasMensais() > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} "
                                    style="margin-right: 5px;">
                                </i>
                                {{ Dashboard::porcentagemVendasMensais() }} %
                            </span>
                            <span class="text-truncate" style="color: var(--bs-gray-500);margin-left: 10px;">
                                Last month: R$ {{ Dashboard::salesMonth(2) }}
                            </span>
                        </div>
                        <p class="fs-2 text-start card-text"><br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card col-md-12 col-sm-12" style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);" type="button" data-bs-toggle="modal" data-bs-target="#definirMeta">
            <div class="card-body text-center shadow-sm" style="height: 200px;">
                <div class="row">
                    <div class="col-9 text-nowrap">
                        <h4 class="text-start" style="font-family: Roboto, sans-serif;color: rgb(171,171,171);">Monthly
                            goal<br /></h4>
                        <p class="text-start" style="margin-top: 16px;">R$ {{ Dashboard::salesMonth() }} / R$
                            {{ Dashboard::monthGoal() }}
                        </p>
                    </div>
                    <div class="col text-truncate text-end"><i class="fa fa-google-wallet fs-1"></i></div>
                </div>
                <div class="progress" style="height: 50px;border-radius: 22px;font-size: 22px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100" style="width: {{ Dashboard::porcentagemGoal() }}%;">
                        {{ Dashboard::porcentagemGoal() }}%</div>
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
                             step="any"
                            style="background: rgba(255, 255, 255, 0);border-radius: 10px;" placeholder="Valor" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Definir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-12" style="margin-bottom: 15px;">
                <div class="card col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);">
                    <div class="card-body text-center shadow-sm" style="height: ;">
                        <div class="row">
                            <div class="col-9 text-nowrap">
                                <h4 class="text-start" style="font-family: Roboto, sans-serif;color: rgb(171,171,171);">
                                    Info<br></h4>
                            </div>
                            <div class="col text-truncate text-end"><i class="material-icons fs-1">info_outline</i></div>
                        </div>
                        <div class="col">
                            <p class="text-start">Monthly daily average:<br> R$
                                {{ Dashboard::dailyAvg() }}
                        </div>
                        <p class="text-start card-text">Previous months: <br>

                            {{-- CHART --}}
                            <canvas id="myChart" width="100" height="50px"></canvas>

                            {{-- DADOS --}}
                            @for ($i = 7; $i > 0; $i--)                           

                                <input type="hidden" id="{{ 'hiddeninput' . $i }}"
                                    value="{{ Dashboard::verificarMes(Dashboard::month($i)) }}" />

                                <input type="hidden" id="{{ 'hiddeninputValue' . $i }}"
                                    value="{{ Dashboard::salesMonth($i) }}" />
                            @endfor

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('chart.js/chart.js') }}"></script>
    <script>
        const labels = [];
        const valores = [];
        for (var i = 7; i > 0; i--) {
            labels.push(document.getElementById('hiddeninput' + i).value);
            valores.push(document.getElementById('hiddeninputValue' + i).value);
        }

        const data = {
            labels: labels,
            datasets: [{
                label: 'Revenue in R$',
                backgroundColor: '#72d584',
                borderColor: 'rgb(255, 255, 255)',
                data: valores,
            }]
        };
        var delayed;
        const config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 800 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        };
    </script>
    <script>
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

@endsection
