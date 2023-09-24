@extends('admin.master.layout')
@section('title', 'Entrada Produto')
@section('page-name', 'Entrada Produto')
@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 10px; margin-top: 20px">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                     style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                         style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        <form id="personForm" name="personForm" method="POST" action="/entradaestoque"
                              data-url="{{ route('load_prod_cat') }}">
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86); margin-bottom: 10px">Dados
                            </h4>
                            <label for="category_id">Categoria</label>
                            <select class="form-select text-light bg-dark"
                                    id="category_id" name="category_id"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);">
                                <optgroup label="Categoria">
                                    <option disabled selected value=""> Categoria</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <label for="product">Produto</label>
                            <select class="form-select text-light bg-dark" id="product" name="product"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color: rgb(0, 0, 0);">
                                <optgroup label="Produto">
                                    <option disabled selected value="">Produto</option>
                                </optgroup>
                            </select>
                            <label for="amount">Quantidade</label>
                            <input class="form-control" type="text" id="amount" required=""
                                   onkeyup="insere(),changeTotalValue()" placeholder="Quantidade (*)"
                                   name="amount"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="expiration_date">Validade</label>
                            <x-datetime-picker
                                    without-timezone
                                    label="Appointment Date"
                                    placeholder="Appointment Date"
                                    wire:model="withoutTimezone"
                            />
                            <input class="form-control" id="expiration_date" type="date"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-gray-300);border-radius: 10px;border-color: var(--bs-gray-600);"
                                   name="expiration_date"/>
                            <h4 class="text-center"
                                style="color: rgba(246, 247, 248, 0.86);margin-top: 10px;margin-bottom: 10px;">
                                Valores
                            </h4>
                            <label for="cost">Custo Unitario</label>
                            <input class="form-control" type="text" id="cost" required=""
                                   onkeyup="insere(),changeTotalValue()" placeholder="Custo Unitário (*)" name="cost"
                                   style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="cost_total">Custo Total</label>
                            <input class="form-control" type="text" id="cost_total" required=""
                                   onkeyup="insere(),changeUnitValue()" placeholder="Custo Total" name="cost_total"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <label for="sale">Valor de venda</label>
                            <input class="form-control" type="text" id="sale" onkeyup="insere()"
                                   placeholder="Valor de Venda" name="sale"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <p class="font-monospace text-center" id="profit"></p>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio1"
                                           name="radio"/><label class="form-check-label" for="formCheck-1">25%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio2"
                                           name="radio"/><label class="form-check-label" for="formCheck-2">50%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio3"
                                           name="radio"/>
                                    <label class="form-check-label" for="formCheck-3">75%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" onclick="radioCalculo(),insere()"
                                           id="radio4"
                                           name="radio"/><label class="form-check-label" for="formCheck-4">90%</label>
                                </div>
                            </div>
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px; margin-top: 10px" title="Cadastrar">Adicionar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const changeUnitValue = () => {
            const cost = document.getElementById("cost");
            const cost_total = parseFloat(
                document.getElementById("cost_total").value
            );
            const amount = document.getElementById("amount").value;

            const result = cost_total / amount;

            cost.value = result.toFixed(2);
        };

        function changeTotalValue() {
            const cost = parseFloat(document.getElementById("cost").value);
            const cost_total = document.getElementById("cost_total");
            const amount = document.getElementById("amount").value;

            let result = cost * amount;

            cost_total.value = result.toFixed(2);
        }


        const insere = () => {
            const cost = parseFloat(document.getElementById("cost").value);
            const sale_value = parseFloat(document.getElementById("sale").value);
            const profit = document.getElementById("profit");

            const profit_value = sale_value - cost;
            const result = (profit_value / sale_value) * 100;

            profit.textContent = result >= 0 ? `+ ${result.toFixed(2)}%` : "";
        };

        const radioCalculo = () => {
            const sale_price = document.getElementById("sale");
            const radioBtn25 = document.getElementById("radio1");
            const radioBtn50 = document.getElementById("radio2");
            const radioBtn75 = document.getElementById("radio3");
            const radioBtn100 = document.getElementById("radio4");
            const cost = parseFloat(document.getElementById("cost").value);

            if (cost !== 0) {
                let percent, z, x, y, result;

                switch (true) {
                    case radioBtn25.checked:
                        percent = 25;
                        break;
                    case radioBtn50.checked:
                        percent = 50;
                        break;
                    case radioBtn75.checked:
                        percent = 75;
                        break;
                    case radioBtn100.checked:
                        percent = 90;
                        break;
                    default:

                        break;
                }
                if (percent !== undefined) {
                    z = 100;
                    x = parseFloat(percent / z);
                    y = 1 - x;
                    result = cost / y;
                    sale_price.value = result.toFixed(2);
                }
            }
        };


    </script>

    @vite(['/resources/js/product_add_page.js'])
@endsection
