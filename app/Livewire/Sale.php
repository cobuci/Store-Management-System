<?php

namespace App\Livewire;


use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use App\Models\Product;
use App\{Http\Controllers\CaixaController,
    Http\Controllers\FinanceController,
    Http\Controllers\HistoryController,
    Models\Sale as SaleModel
};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use stdClass;
use WireUi\Traits\Actions;

class Sale extends Component
{
    use Actions;

    protected array $rules = [
        'product' => ['required'],
        'amount' => ['required'],
    ];
    public $products = [];
    public $product = '';
    public $list = [];
    public $bonus = 0;
    public $amount = '';

    public string $finalPrice;
    public string $finalCost;

    public $customers = [];
    public $customer = '';
    public $discount = 0;
    public $price = 0;
    public $payment_method = 'Dinheiro';


    public function addProduct(): void
    {
        $this->validate();
        $product = Product::find($this->product);
        $this->list[] = [
            'id' => $this->product,
            'name' => $product->name,
            'brand' => $product->brand,
            'weight' => $product->weight,
            'amount' => $this->amount,
            'sale' => $product->sale,
            'cost' => $product->cost,
        ];
        $this->reset(['product', 'amount']);
    }


    public function teste(): void
    {
        dd($this->list);
    }

    public function saveSale(): void
    {
        $order_id = uniqid('', true);
        $paramsOrder = new stdClass();

        foreach ($this->list as $key => $item) {
            $paramsOrder->order_id = $order_id;
            $paramsOrder->product_id = $item['id'];
            $paramsOrder->amount = $item['amount'];
            ProductController::removeStock($item['id'], $item['amount']);
            OrderController::newOrder($paramsOrder);
        }
        $this->storeSale($order_id);

        $this->reset(['customer', 'discount', 'list']);
    }

    public function storeSale($order_id): void
    {

        $fee = 1;
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $creditFee = $getConfig->cardFee->credit;
        $debitFee = $getConfig->cardFee->debit;

        $this->payment_method == "Credito" ? $fee = $creditFee : null;
        $this->payment_method == "Debito" ? $fee = $debitFee : null;

        $finalPrice = floatval(str_replace(",", ".", $this->finalPrice)) * $fee;
        $finalCost = floatval(str_replace(",", ".", $this->finalCost));

        $customer = Customer::find($this->customer);
        SaleModel::create([
            'customer_id' => $customer->id ?? null,
            'customer_name' => $customer->name ?? null,
            'order_id' => $order_id,
            'price' => $finalPrice,
            'cost' => $finalCost,
            'discount' => $this->discount,
            'payment_method' => $this->payment_method,
            'payment_status' => 0,
        ]);
        CaixaController::addBalance($finalPrice);
        FinanceController::addSale($finalPrice);
        HistoryController::addToHistory("txn", "Nova venda realizada ");
    }

    public function removeProduct($id): void
    {
        unset($this->list[$id]);
    }

    public function calculateTotal(): string
    {
        $total = 0;

        foreach ($this->list as $item) {
            $total += $item['sale'] * $item['amount'];
        }
        $total -= $this->discount;
        $this->bonus == 1 ? $total = 0 : null;
        return number_format($total, 2, ',', '.');
    }

    public function calculateCost(): string
    {
        $total = 0;

        foreach ($this->list as $item) {
            $total += $item['cost'] * $item['amount'];
        }

        return number_format($total, 2, ',', '.');
    }

    public function mount(): void
    {
        $this->customers = Customer::show();
        $this->products = Product::get();
    }

    public function render(): View|Factory|Application
    {

        $this->finalPrice = $this->calculateTotal();
        $this->finalCost = $this->calculateCost();

        return view('admin.sale_page');
    }
}