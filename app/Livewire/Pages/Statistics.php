<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use DB;
use Livewire\Component;

class Statistics extends Component
{

    public $date = [
        'start' => '',
        'end' => '',
    ];

    public $values = [
        'cost' => 0,
        'sale' => 0,
        'profit' => 0,
    ];
    public $categories = [];
    public $sales;
    public $products = [];
    public $payment_method = [
        'Dinheiro' => 0,
        'Credito' => 0,
        'Debito' => 0,
        'PIX' => 0,
        'Outros' => 0,
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedDate()
    {

        $firstSale = Sale::orderBy('created_at', 'asc')->first();
        if (empty($this->date['start'])) {
            $this->date['start'] = $firstSale->created_at->toDateString();
        }
        if (empty($this->date['end'])) {
            $this->date['end'] = date('Y-m-d', strtotime('+1 day'));
        }
        $this->values['cost'] = $this->costValueTotal();
        $this->values['sale'] = $this->saleValueTotal();
        $this->values['profit'] = $this->profitValue();
        $this->sales = $this->getSales();
        $this->products = $this->getProducts();
        $amounts = array_column($this->products, 'amount');
        array_multisort($amounts, SORT_DESC, $this->products);
        $this->paymentMethodTotal();
    }

    public function costValueTotal()
    {
        return Sale::where('created_at', '>=', $this->date['start'])
            ->where('created_at', '<=', $this->date['end'])
            ->sum('cost');
    }

    public function saleValueTotal()
    {
        return Sale::where('created_at', '>=', $this->date['start'])
            ->where('created_at', '<=', $this->date['end'])
            ->sum('price');
    }

    public function profitValue()
    {
        return $this->saleValueTotal() - $this->costValueTotal();
    }

    public function getSales()
    {
        return Sale::with('orders')
            ->where('created_at', '>=', $this->date['start'])
            ->where('created_at', '<=', $this->date['end'])
            ->get();
    }

    public function getProducts()
    {
        $products = [
            ['id' => '',
                'name' => '',
                'amount' => '',
                'brand' => '',
                'cost' => '',
                'sale' => '',
                'weight' => '',
                'profit' => '',
                'category_id' => ''
            ]
        ];
        foreach ($this->sales as $sale) {

            foreach ($sale->orders as $order) {
                $productId = $order->product_id;
                $categoryId = Product::find($productId)?->category_id;

                // Verifica se o produto já está no array $products
                if (isset($products[$productId])) {
                    // Se sim, atualiza as quantidades e custos
                    $products[$productId]['amount'] += $order->amount;
                    $products[$productId]['cost'] += $order->unit_cost * $order->amount;
                    $products[$productId]['sale'] += $order->unit_price * $order->amount;
                    $products[$productId]['profit'] += ($order->unit_price * $order->amount) - ($order->unit_cost * $order->amount);
                } else {
                    // Se não, cria um novo registro para o produto
                    $products[$productId] = [
                        'id' => $productId,
                        'name' => $order->product_name,
                        'brand' => $order->product_brand,
                        'amount' => $order->amount,
                        'weight' => $order->weight,
                        'cost' => $order->unit_cost * $order->amount,
                        'sale' => $order->unit_price * $order->amount,
                        'profit' => ($order->unit_price * $order->amount) - ($order->unit_cost * $order->amount),
                        'category_id' => $categoryId,
                    ];
                }


            }
        }
        return $products;

    }

    public function paymentMethodTotal()
    {

        $methods = Sale::select('payment_method', DB::raw('SUM(price) as total_price'))
            ->where('created_at', '>=', $this->date['start'])
            ->where('created_at', '<=', $this->date['end'])
            ->groupBy('payment_method')
            ->get();

        foreach ($methods as $method) {
            $this->payment_method[$method->payment_method] = $method->total_price;
        }
    }

    public function render()
    {

        return view('admin.tool_statistics');
    }
}
