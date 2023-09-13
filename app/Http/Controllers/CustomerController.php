<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use App\Http\Requests\StoreUpdateCustomer;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Customer $customers)
    {
        $customers = Customer::orderBy('name')
            ->get();

        return view('admin.customer', [
            'clientes' => $customers,
        ]);
    }

    public function filtrar(Request $request)
    {
        $search = $request->input('search');
        $data = Customer::select('id', 'name', 'street')->where('name', 'LIKE', '%' . $search . '%')->get();

        if ($request->ajax()) {
            return view('admin.customer_partial', compact('data'));
        }

        return view('admin.customer_partial', compact('data'));
    }


    public function search(Request $request)
    {
        $query = $request->input('search');
        $customers = Customer::where('name', 'LIKE', "%$query%")->get();

        return response()->json($customers);
    }


    public function cadastrar()
    {
        return view('admin.customer_register');
    }

    public static function listar()
    {
        return Customer::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function store(StoreUpdateCustomer $request)
    {
        Customer::create($request->all());
        return redirect()->route('admin.customer');
    }

    public function show($id)
    {
        if (!$cliente = Customer::find($id)) {
            return redirect()->back();
        } else {
            $totalSpent = 0;
            $totalDebit = 0;
            $totalAgua = 0;
            $all_purchases = Sale::latest("id")->where('customer_id', 'LIKE', $id)->get();
            foreach (CustomerController::customerPurchases($id) as $order) {
                $totalSpent += $order->price;
                if ($order->product = "") {
                    $totalAgua += $order->amount;
                }
            }
            foreach (CustomerController::unpaidPurchases($id) as $order) {
                $totalDebit += $order->price;
            }

            $apiGoogle = env('GOOGLE_API_KEY');

            $result = CustomerController::searchCustomerAddress($cliente->id);
            $latitude = $result[0];
            $longitude = $result[1];

            return view('admin.customer_profile', compact('cliente', 'totalSpent', 'totalDebit', 'apiGoogle', 'latitude', 'longitude', 'all_purchases'));
        }
    }


    public static function searchCustomerAddress($id)
    {
        $customers = Customer::find($id);
        $apiGoogle = env('GOOGLE_API_KEY');
        if ($customers->street) {
            $address = $customers->street . ',' . $customers->number . ',' . $customers->district;
        } else {
            $address = "São Paulo";
        }

        $formattedAddress = urlencode($address);

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$formattedAddress}&key={$apiGoogle}";

        $response = file_get_contents($url);

        $data = json_decode($response);

        if ($data->status === 'OK') {
            $latitude = $data->results[0]->geometry->location->lat;
            $longitude = $data->results[0]->geometry->location->lng;
        }

        return [$latitude, $longitude];
    }

    public static function customerPurchases($id)
    {

        return DB::table('sales')
            ->latest()
            ->where('customer_id', '=', $id)
            ->get();
    }

    public static function unpaidPurchases($id)
    {

        return DB::table('sales')
            ->latest()
            ->where('customer_id', '=', $id)
            ->where('payment_status', '=', "0")
            ->get();
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
        $customer = Customer::find($id);

        $customer->delete();

        return redirect()->route('admin.customer');
    }

    public function put($id, StoreUpdateCustomer $request)
    {
        $customer = Customer::find($id);

        $customer->update($request->all());

        return redirect('/cliente/{$id}');
    }

}
