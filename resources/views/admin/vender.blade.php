@extends('admin.master.layout')
@section('title', 'Vender')
@section('page-name', 'Vender')
@section('content')
    <div class="col-sm-12 col-md-8 offset-md-2" style="border-style: none;">
        <div class="card bg-light shadow-lg col-md-12 col-sm-12"
             style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
            <div class="card-body shadow-sm"
                 style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                <h1 class="text-center text-light"> {{ date('d / m / Y') }}</h1>
                <form id="personForm" name="personForm" method="post" action="{{ route('admin.orders.store') }}"
                      data-url="{{ route('load_prod_cat') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-4" style="margin-bottom: 15px;">
                            <select class="form-select text-light bg-dark" id="categoria"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);">
                                <optgroup label="Categoria">
                                    <option disabled selected value="null"> Categoria</option>
                                    @foreach (Category::show() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <select class="form-select text-light bg-dark" id="product" onchange=""
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);">
                                <optgroup label="Produto">
                                    <option selected disabled value=""> Produto</option>
                                </optgroup>
                            </select>


                            <input class="form-control" type="number" id="amount" onkeyup=""
                                   placeholder="Quantidade (*)"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                            <button class="btn btn-outline-light font-monospace shadow-sm" data-bs-toggle="tooltip"
                                    onclick="" id="adicionar" data-bss-tooltip="" data-bs-placement="bottom" type=""
                                    style="border-radius: 10px;margin-top: 10px;width: 100%;"
                                    title="Adicionar">Adicionar
                            </button>
                            <button class="btn btn-outline-light font-monospace shadow-sm" data-bs-toggle="tooltip"
                                    id="remover" data-bss-tooltip="" data-bs-placement="bottom" type=""
                                    style="border-radius: 10px;margin-top: 10px;width: 100%;" title="Adicionar">Remover
                            </button>
                        </div>
                        <div class="col-sm-12 col-md-5"
                             style="border-radius: 15px;padding-top: 10px;border: 2px dotted #8c61ff;margin-bottom: 15px;">
                            <ul class="item-unstyled ulProduto" id="lista">

                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-3" style="margin-bottom: 15px;">
                            <input class="form-control" type="text" id="discount"
                                   placeholder="Desconto (R$)" name="discount"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <input type="hidden" id="item_amount" name="item_amount">
                            <input class="form-control" type="text" id="total_price" required=""
                                   placeholder="Valor Total"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric" readonly=""/>

                            <select class="form-select text-light bg-dark" id="payment_method"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                    name="payment_method">
                                <optgroup label="Forma de Pagamento">
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="PIX">PIX</option>
                                    <option value="Credito">Cartão Crédito</option>
                                    <option value="Debito">Cartão Debito</option>
                                    <option value="Outro">Outro</option>
                                </optgroup>
                            </select>
                            <select class="form-select text-light bg-dark" id="bonificacao"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                    name="bonificacao">
                                <optgroup label="Bonificação">
                                    <option value="0">Bonificação</option>
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </optgroup>
                            </select>
                            <select class="form-control text-light bg-dark" id="customer_id" style="width: 100%"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                    name="customer_id">
                                <optgroup label="">
                                    <option value="null"> Cliente</option>
                                    @foreach (Customer::listar() as $customer)
                                        <option value="{{ $customer->id }}">#{{ $customer->id }} -
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>

                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px; margin-top: 10px" title="Cadastrar">
                                Vender
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@vite(['/resources/js/sale_page.js'])
