<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreUpdateCliente;
use App\Models\Venda;
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
        $dados = Cliente::select('id','nome','rua')->where('nome', 'LIKE', '%'.$search.'%')->get();

        if ($request->ajax()) {
            return view('admin.clientePartial', compact('dados'));
        }        

        return view('admin.clientePartial', compact('dados'));
    }

    public function cadastrar()
    {
        return view('admin.clienteCadastro');
    }

    public static function listar()
    {
     
        $cliente = Cliente::select('id','nome')
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
            return view('admin.perfilCliente', compact('cliente', 'totalSpent', 'totalDebit'));
        }
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

        $aguas = DB::table('vendas')
            ->where('id_cliente', '=', $id)
            ->where('id_produto', '=', 2)
            ->select(DB::raw('SUM(quantidade) as quantidade'))
            ->get();

        $aguas = json_decode($aguas, true);
        $aguas = $aguas[0]['quantidade'];


        return ($aguas);
    }
}
