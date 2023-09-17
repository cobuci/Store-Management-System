<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use App\Http\Requests\StoreUpdateCustomer;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name')
            ->get();

        return view('admin.customer', compact('customers'));
    }

    public function filter(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::select('id', 'name', 'street')->where('name', 'LIKE', '%' . $search . '%')->get();

        if ($request->ajax()) {
            return view('admin.customer_filter', compact('customers'));
        }

        return view('admin.customer_filter', compact('customers'));
    }


    public function search(Request $request)
    {
        $query = $request->input('search');
        $customers = Customer::where('name', 'LIKE', "%$query%")->get();

        return response()->json($customers);
    }


    public function register()
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

        if (!$customer = Customer::find($id)) {
            return redirect()->back();
        } else {
            $totalSpent = 0;
            $totalDebit = 0;

            $all_purchases = Sale::latest("id")->where('customer_id', 'LIKE', $id)->get();
            foreach (CustomerController::customerPurchases($id) as $order) {
                $totalSpent += $order->price;
            }
            foreach (CustomerController::unpaidPurchases($id) as $order) {
                $totalDebit += $order->price;
            }

            $apiGoogle = env('GOOGLE_API_KEY');

            $result = CustomerController::searchCustomerAddress($customer->id);
            $latitude = $result[0];
            $longitude = $result[1];
            $water_amount = self::waterAmount($id);

            return view('admin.customer_profile', compact('customer', 'totalSpent', 'totalDebit', 'apiGoogle', 'latitude', 'longitude', 'all_purchases', 'water_amount'));
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

    public static function waterAmount($id)
    {

        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $water_id = $getConfig->water->value;



        $water = DB::table('orders')
            ->join('sales', 'orders.order_id', '=', 'sales.order_id')
            ->where('sales.customer_id', '=', $id)
            ->where('orders.product_id', '=', $water_id)
            ->select(
                'orders.product_id',
                DB::raw('sum(orders.amount) as water_amount'),

            )
            ->get();
        $water = json_decode($water, true);
        $water = $water[0]['water_amount'];


        return ($water);
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

        return back();
    }

}
