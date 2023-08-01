
@extends('admin.master.layout')
@section('title', 'Configurações')
@section('page-name', 'Configurações')
@section('content')


    <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
        <div class="col-sm-12 col-md-8 offset-md-2" style="border-style: none;">
            <div class="card bg-light shadow-lg col-md-12 col-sm-12"
                style="border-radius: 22px;background: #3d3d3d;color: rgb(238,238,238);border-style: none;border-color: var(--bs-purple);">
                <div class="card-body shadow-sm"
                    style="background: #3d3d3d;border-radius: 10px;border-color: rgba(255,255,255,0);">

                    <div class="row">
                        <div class="col-sm-12 col-md-12">

                            @foreach (Settings::listarSettings() as $list)
                                <div>
                                    {{ $list->descricao }} -
                                    {{ $list->valor }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
