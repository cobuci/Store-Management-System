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

        $cliente = Cliente::paginate(9);

        return view('admin.clientes', [
            'clientes' => $cliente,
        ]);
    }

    public function cadastrar()
    {
        return view('admin.clienteCadastro');
    }

    public static function listar()
    {
        $cli = new Cliente;
        $cliente = $cli->get();

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
            $totalAgua = 0;
            foreach (ClienteController::comprasCliente($id) as $compra) {
                $totalSpent += $compra->precoVenda;
                if ($compra->produto = "") {
                    $totalAgua += $compra->quantidade;
                }
            }
            return view('admin.perfilCliente', compact('cliente', 'totalSpent'));
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
