@extends('admin.master.layout')
@section('title', 'Dashboard')
@section('page-name', 'Fardo (abrir / fechar)')
@section('content')

    {{-- ABRIR FARDO --}}
    <div class="container">
        <h1 class="text-center text-light">Abrir Fardo</h1>
        <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4" style="border-style: none;">
                <div
                    class="card bg-light shadow-lg col-md-12 col-sm-12"style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
                    <div
                        class="card-body shadow-sm"style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                        <form method="post"action="{{ route('admin.pack.open') }}">
                            @csrf                            
                            <div class="row justify-content-center">
                                <div class="col-12" style="margin-bottom: 15px;">
                                    <p>De</p>
                                    <select class="form-select text-light bg-dark"
                                        id="selectedPack"style="border-radius: 10px;margin-bottom: 10px;background: rgba(255,255,255,0);border-color: rgba(255,255,255,0.17);color: var(--bs-white);"name="selectedPack">
                                        <optgroup label="selectedPack">
                                            @foreach (Produto::listar() as $prod)
                                                @if ($prod->id_categoria == 4 && $prod->quantidade > 0)
                                                    <option value="{{ $prod->id }}">
                                                        {{ $prod->quantidade . ' - ' . $prod->marca . ' - ' . $prod->peso }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input class="form-control" type="number" id="qtProd"
                                        required=""placeholder="Quantidade (*)"name="qtProd"style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                                    <p>Para</p>
                                    <select class="form-select text-light bg-dark"
                                        id="prodTarget"style="border-radius: 10px;margin-bottom: 10px;background: rgba(255,255,255,0);border-color: rgba(255,255,255,0.17);color: var(--bs-white);"name="prodTarget">
                                        <optgroup label="prodTarget">
                                            @foreach (Produto::listar() as $prod)
                                                @if ($prod->id_categoria == 5)
                                                    <option value="{{ $prod->id }}">
                                                        {{ $prod->quantidade . ' - ' . $prod->nome . ' - ' . $prod->marca . ' - ' . $prod->peso }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input class="form-control" type="number" id="qtProdTarget"
                                        required=""placeholder="Quantidade (*)"
                                        name="qtProdTarget"style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                                    <button class="btn btn-outline-light font-monospace shadow-sm"
                                        data-bs-toggle="tooltip"data-bss-tooltip="" data-bs-placement="bottom"
                                        type="submit"style="border-radius: 10px;margin-top: 10px;width: 100%;"title="Adicionar">Abrir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- FECHAR FARDO --}}

    <div class="container" style="margin-top: 20px;">
        <h1 class="text-center text-light">Fechar Fardo</h1>
        <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4" style="border-style: none;">
                <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                    style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
                    <div class="card-body shadow-sm"
                        style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">
                        <form method="post"action="{{ route('admin.pack.close') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-12" style="margin-bottom: 15px;">
                                    <p>De</p>
                                    <select class="form-select text-light bg-dark"
                                        id="selectedPack"style="border-radius: 10px;margin-bottom: 10px;background: rgba(255,255,255,0);border-color: rgba(255,255,255,0.17);color: var(--bs-white);"name="selectedPack">
                                        <optgroup label="selectedPack">
                                            @foreach (Produto::listar() as $prod)
                                                @if ($prod->id_categoria == 5 && $prod->quantidade > 0)
                                                    <option value="{{ $prod->id }}">
                                                        {{ $prod->quantidade . ' - ' . $prod->nome . ' - ' . $prod->marca . ' - ' . $prod->peso }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input class="form-control" type="text" id="qtProd"
                                        required=""placeholder="Quantidade (*)"
                                        name="qtProd"style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                                    <p>Para</p>
                                    <select class="form-select text-light bg-dark"
                                        id="prodTarget"style="border-radius: 10px;margin-bottom: 10px;background: rgba(255,255,255,0);border-color: rgba(255,255,255,0.17);color: var(--bs-white);"name="prodTarget">
                                        <optgroup label="Categoria">
                                            @foreach (Produto::listar() as $prod)
                                                @if ($prod->id_categoria == 4)
                                                    <option value="{{ $prod->id }}">
                                                        {{ $prod->quantidade . ' - ' . $prod->marca . ' - ' . $prod->peso }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input class="form-control" type="text" id="qtProdTarget" required=""
                                        placeholder="Quantidade (*)"
                                        name="qtProdTarget"style="background: rgba(255,255,255,0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255,255,255,0.17);">
                                    <button class="btn btn-outline-light font-monospace shadow-sm"
                                        data-bs-toggle="tooltip"data-bss-tooltip="" data-bs-placement="bottom"
                                        type="submit"style="border-radius: 10px;margin-top: 10px;width: 100%;"title="Adicionar">Fechar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
