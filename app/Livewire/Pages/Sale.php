<?php

namespace App\Livewire\Pages;


use App\{Http\Controllers\CashierController,
    Http\Controllers\FinanceController,
    Http\Controllers\HistoryController,
    Models\Category,
    Models\Sale as SaleModel};
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use stdClass;
use WireUi\Traits\Actions;

class Sale extends Component
{
    use Actions;

    public $products = [];
    public $product = '';
    public $list = [];
    public $categories = [];
    public $category = 0;
    public $bonus = 0;
    public $amount;
    public string $finalPrice;
    public string $finalCost;
    public $customers = [];
    public string $customer = '';
    public $discount = 0;
    public $price = 0;
    public string $payment_method = 'Dinheiro';
    protected array $rules = [
        'product' => ['required'],
        'amount' => ['required'],
    ];

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


    public function saveSale(): void
    {
        $order_id = uniqid('', true);
        $paramsOrder = new stdClass();

        if($this->list == null){
            $this->notification()->error(
                $title = 'Error !!!',
                $description = 'Adicione produtos para realizar a venda',
            );
            return;
        }
        $this->storeSale($order_id);

        foreach ($this->list as $key => $item) {
            $paramsOrder->order_id = $order_id;
            $paramsOrder->product_id = $item['id'];
            $paramsOrder->amount = $item['amount'];
           ProductController::removeStock($item['id'], $item['amount']);
           OrderController::newOrder($paramsOrder);
        }

        $this->reset(['customer', 'discount', 'list']);
    }

    public function storeSale($order_id)
    {
        $fee = 1;
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $creditFee = $getConfig->cardFee->credit;
        $debitFee = $getConfig->cardFee->debit;

        $this->payment_method == "Credito" ? $fee = $creditFee : null;
        $this->payment_method == "Debito" ? $fee = $debitFee : null;

        $finalPrice = (str_replace(['.', ','], ['', '.'],$this->finalPrice)) * $fee;
        $finalPrice = floatval($finalPrice);

        $finalCost = (str_replace(['.', ','], ['', '.'],  $this->finalCost));
        $finalCost = floatval($finalCost);

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
        CashierController::addBalance($finalPrice);
        FinanceController::addSale($finalPrice);
        HistoryController::addToHistory("txn", "Nova venda realizada ");

        return redirect()->route('admin.reports');
    }

    public function removeProduct($id): void
    {
        unset($this->list[$id]);
    }

    public function mount(): void
    {
        $this->customers = Customer::show();
        $this->categories = Category::all();
    }

    public function updatedCategory(): void
    {
        $this->products = Product::where('category_id', 'LIKE', $this->category)->get();
    }

    public function render(): View|Factory|Application
    {

        $this->finalPrice = $this->calculateTotal();
        $this->finalCost = $this->calculateCost();

        return view('admin.sale_page');
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
}
