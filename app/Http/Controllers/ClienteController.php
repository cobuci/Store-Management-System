<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

use App\Http\Requests\StoreUpdateCliente;

use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(Cliente $cliente)
    {

        $cliente = Cliente::orderBy('nome', 'asc')
            ->get();

        return view('admin.clientes', [
            'clientes' => $cliente,
        ]);
    }

    public function filtrar(Request $request)
    {
        $search = $request->input('search');
        $dados = Cliente::select('id', 'nome', 'rua')->where('nome', 'LIKE', '%' . $search . '%')->get();

        if ($request->ajax()) {
            return view('admin.clientePartial', compact('dados'));
        }

        return view('admin.clientePartial', compact('dados'));
    }


    public function search(Request $request)
    {
        $query = $request->input('search');
        $clientes = Cliente::where('nome', 'LIKE', "%$query%")->get();

        return response()->json($clientes);
    }


    public function cadastrar()
    {
        return view('admin.clienteCadastro');
    }

    public static function listar()
    {

        $cliente = Cliente::select('id', 'nome')
            ->orderBy('nome', 'asc')
            ->get();

        return $cliente;
    }

    public function store(StoreUpdateCliente $request)
    {

        $cliente = new Cliente();

        $cliente->nome = $request->nome;
        $cliente->email = $request->email;
        $cliente->telefone = $request->telefone;
        $cliente->sexo = $request->sexo;
        $cliente->cep = $request->cep;
        $cliente->rua = $request->rua;
        $cliente->numero = $request->numero;
        $cliente->bairro = $request->bairro;

        $cliente->save();

        return redirect('/cliente');
    }

    public function show($id)
    {
        if (!$cliente = Cliente::find($id)) {
            return redirect()->back();
        } else {
            $totalSpent = 0;
            $totalDebit = 0;
            $totalAgua = 0;
            foreach (ClienteController::comprasCliente($id) as $compra) {
                $totalSpent += $compra->precoVenda;
                if ($compra->produto = "") {
                    $totalAgua += $compra->quantidade;
                }
            }
            foreach (ClienteController::unpaidPurchases($id) as $compra) {
                $totalDebit += $compra->precoVenda;
            }

            $apiGoogle = env('GOOGLE_API_KEY');

            $resultadoMapa = ClienteController::buscarClienteMapa($cliente->id);
            $latitude = $resultadoMapa[0];        
            $longitude = $resultadoMapa[1];        
            
            return view('admin.perfilCliente', compact('cliente', 'totalSpent', 'totalDebit','apiGoogle','latitude','longitude'));
        }
    }

    
    public static function buscarClienteMapa($id){
        $cliente = Cliente::find($id);
        $apiGoogle = env('GOOGLE_API_KEY');
        if ($cliente->rua) {
            $endereco = $cliente->rua . ','. $cliente->numero .','. $cliente->bairro;
        }else{
            $endereco = "São Paulo";
        }       
        
        // Formatação do endereço para a URL da API
        $endereco_formatado = urlencode($endereco);
        
               
        // URL da API do Google Maps Geocoding
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$endereco_formatado}&key={$apiGoogle}";
        
        // Fazendo a requisição à API
        $response = file_get_contents($url);
        
        // Decodificando a resposta JSON
        $data = json_decode($response);      

        
        if ($data->status === 'OK') {
            $latitude = $data->results[0]->geometry->location->lat;
            $longitude = $data->results[0]->geometry->location->lng;    
        } 

        return [$latitude,$longitude];
    }

    public static function comprasCliente($id)
    {

        $venda = DB::table('vendas')
            ->latest()
            ->where('id_cliente', '=', $id)
            ->get();


        return $venda;
    }

    public static function unpaidPurchases($id)
    {

        $venda = DB::table('sales')
            ->latest()
            ->where('id_cliente', '=', $id)
            ->where('status_pagamento', '=', "0")
            ->get();


        return $venda;
    }

    public static function quantidadeAgua($id)
    {

        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $waterAmount = $getConfig->water->value;

        $aguas = DB::table('vendas')
            ->where('id_cliente', '=', $id)
            ->where('id_produto', '=', $waterAmount)
            ->select(DB::raw('SUM(quantidade) as quantidade'))
            ->get();

        $aguas = json_decode($aguas, true);
        $aguas = $aguas[0]['quantidade'];


        return ($aguas);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        $cliente->delete();

        return redirect('/cliente');
    }

    public function put($id, StoreUpdateCliente $request)
    {
        $cliente = Cliente::find($id);

        $data = $request->only('nome', 'email', 'telefone', 'sexo', 'cep', 'rua','numero','bairro');        

        $cliente->update($data);
       
        return redirect('/cliente/{$id}');
    }

}
