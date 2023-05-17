@extends('admin.master.layout')
@section('title', 'Editar Produto')
@section('page-name', 'Editar Produto')
@section('content')
    <div class="container">
        <h1 class="text-center text-light">Editando o produto #{{$produto->id}}-{{$produto->nome}}</h1>
        <div class="row" style="margin-bottom: 10px; margin-top: 20px">
            <div class="col-sm-12 col-md-6 offset-md-3" style="border-style: none">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238, 238, 238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255, 255, 255, 0);">
                        @include('admin.master.alertaErro')
                        <form method="post" action=" {{ route('produto.editar', $produto->id)}}">
                            @method('PUT')
                            @csrf
                            <h4 class="text-center" style="color: rgba(246, 247, 248, 0.86)">
                                Dados
                            </h4>
                            
                            <select class="form-select text-light bg-dark" id="categoria"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                name="categoria">
                                <optgroup label="Categoria">
                                    <option value="{{$produto->id_categoria}}">Categoria</option>
                                    @foreach (Categoria::listar() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <input name="id" type="hidden" value="{{$produto->id}}">
                            <input class="form-control" type="text" id="nome" placeholder="Nome (*)"
                                name="nome" value="{{$produto->nome}}"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);" />
                            <input class="form-control" type="text" id="marca"  placeholder="Marca" name="marca" value="{{$produto->marca}}"
                                style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="tel" />
                            <input class="form-control" type="text" id="peso"  placeholder="Unidade (*)" 
                                name="peso"
                                style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                                inputmode="numeric" />
                            <select class="form-select text-light bg-dark" id="tipoPeso"
                                style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
                                name="tipoPeso">
                                <optgroup label="Unidade">
                                    <option value="L">Litros</option>
                                    <option value="ml">Mililitros</option>
                                    <option value="KG">Kg</option>
                                    <option value="g">Gramas</option>
                                    <option value="un">Unidade</option>
                                </optgroup>
                            </select>
                            <input class="form-control" type="text" id="quantidade" required="" value="{{$produto->quantidade}}"
                            onkeyup="insere(),calcularValorQuantidade()" placeholder="Quantidade (*)" name="quantidade"
                            style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                            inputmode="numeric" />
                        <input class="form-control" id="validade" type="date" 
                            style="background: rgba(255, 255, 255, 0);color: var(--bs-gray-300);border-radius: 10px;border-color: var(--bs-gray-600);"
                            name="validade" />
                        <h4 class="text-center"
                            style="color: rgba(246, 247, 248, 0.86);margin-top: 10px;margin-bottom: 10px;">
                            Valores
                        </h4>
                        <label for="custo">Custo</label>
                        <input class="form-control" type="text" id="custo" required="" value="{{$produto->custo}}"
                            onkeyup="insere(),mudarValorTotal()" placeholder="Custo Unitário (*)" name="custo"
                            style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
                            inputmode="numeric" /> 
                            <label for="venda">Venda</label>                       
                        <input class="form-control" type="text" id="venda" onkeyup="insere()" value="{{$produto->venda}}"
                            placeholder="Valor de Venda" name="venda"
                            style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
                            inputmode="numeric" />

                            <button class="btn btn-outline-light shadow-sm float-end" data-bs-toggle="tooltip"
                                data-bss-tooltip="" data-bs-placement="bottom" type="submit"
                                style="border-radius: 10px; margin-top: 10px" title="editar">
                                Editar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
