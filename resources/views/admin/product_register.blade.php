@extends('admin.master.layout')
@section('title', 'Cadastrar Produto')
@section('page-name', 'Cadastrar Produto')
@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                     style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                         style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        @include('admin.master.alertaErro')
                        <form method="post" action=" {{ route('admin.product.new')}}">
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Dados
                            </h4>
                            <select class="form-select text-light bg-dark" id="category_id" required
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                    name="category_id">
                                <optgroup label="Categoria">
                                    <option disabled selected value="">Categoria</option>
                                    @foreach (Category::listar() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <input class="form-control " type="text" id="name" placeholder="Nome (*)"
                                   name="name" required
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
                            <input class="form-control" type="text" id="brand" placeholder="Marca" name="brand"
                                   style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                            />
                            <input class="form-control" type="text" id="weight" placeholder="Unidade (*)" required
                                   name="weight"
                                   style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                   inputmode="numeric"/>
                            <select class="form-select text-light bg-dark" id="weight_type"
                                    style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                    name="weight_type">
                                <optgroup label="Unidade">
                                    <option value="ml">Mililitros</option>
                                    <option value="L">Litros</option>
                                    <option value="g">Gramas</option>
                                    <option value="KG">Kg</option>
                                    <option value="un">Unidade</option>
                                </optgroup>
                            </select>
                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                    data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                    style="border-radius: 10px; margin-top: 10px" title="Cadastrar">
                                Cadastrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
