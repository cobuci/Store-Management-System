<?php

namespace App\Livewire\Components;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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
        'Outro' => 0,
    ];

    public $pieColors = [
        "Dinheiro" => "#f6ad55",
        "Credito" => "#fc8181",
        "Debito" => "#90cdf4",
        "PIX" => "#68d391",
        "Outro" => "#f6e05e",
    ];

    /**
     * @var array|string[]
     */

    public function mount()
    {
        $this->categories = Category::all();

    }

    #[On('dateUpdated')]
    public function updatedDate($date = null): void
    {
        dump('oi');

        $this->date = $date;

        $this->values['cost'] = $this->costValueTotal();
        $this->values['sale'] = $this->saleValueTotal();
        $this->values['profit'] = $this->profitValue();
        $this->sales = $this->getSales();
        $this->products = $this->getProducts();
        $amounts = array_column($this->products, 'amount');
        array_multisort($amounts, SORT_DESC, $this->products);
        $this->paymentMethodTotal();

        unset($this->pieChartModel);


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

    public function getSales(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Sale::with('orders')
            ->where('created_at', '>=', $this->date['start'])
            ->where('created_at', '<=', $this->date['end'])
            ->get();
    }

    public function getProducts()
    {
        $products = [
            [
                'id' => '',
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

    #[Computed()]
    public function pieChartModel()
    {
        $pieChartModel =
            (new PieChartModel())
                ->setTitle('Método de Pagamento')
                ->setAnimated(true)
                ->addSlice("Dinheiro", doubleval($this->payment_method['Dinheiro']), $this->pieColors['Dinheiro'])
                ->addSlice("Credito", doubleval($this->payment_method['Credito']), $this->pieColors['Credito'])
                ->addSlice("Debito", doubleval($this->payment_method['Debito']), $this->pieColors['Debito'])
                ->addSlice("PIX", doubleval($this->payment_method['PIX']), $this->pieColors['PIX'])
                ->addSlice("Outro", doubleval($this->payment_method['Outro']), $this->pieColors['Outro'])
                ->withLegend()
                ->withDataLabels()
                ->asDonut();
        return $pieChartModel;
    }


    public function placeholder()
    {
        return view('layouts.lazy');
    }

    public function render()
    {
        return view('admin.components.statistics');

    }

}
