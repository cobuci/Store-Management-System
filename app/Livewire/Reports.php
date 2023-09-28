<?php

namespace App\Livewire;

use App\Http\Controllers\OrderController;
use Livewire\Component;
use App\Models\Sale;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Reports extends Component
{
    use WithPagination;
    use Actions;

    public $total = 0;
    public $modal = false;
    public $unconfirmedSale = [];
    public $sale_detail = [
        'id' => '',
        'order_id' => '',
        'cost' => '',
        'discount' => '',
        'profit' => '',
        'customer_name' => '',
        'price' => '',
        'payment_method' => '',
        'created_at' => '',
    ];

    public $products = [];


    public function mount()
    {

        $this->unconfirmedSale = Sale::where('payment_status', 'LIKE', '0')->get()->sortByDesc('id');
        $this->total = 0;
        foreach ($this->unconfirmedSale as $item) {
            if ($item->payment_status == 0) {
                $this->total = $this->total + $item->price;
            }
        }
    }


    public function modalSale($id)
    {
        $this->modal = true;
        $sale = Sale::find($id)->toArray();
        $this->products = Sale::find($id)->orders;

        $this->sale_detail = $sale;
        $this->sale_detail['created_at'] = date('d/m/Y', strtotime($sale['created_at']));
        $this->sale_detail['price'] = number_format($sale['price'], 2, ',', '.');
        $this->sale_detail['cost'] = number_format($sale['cost'], 2, ',', '.');
        $this->sale_detail['profit'] = $sale['price'] - $sale['cost'];
        $this->sale_detail['profit'] = number_format($this->sale_detail['profit'], 2, ',', '.');


    }

   public function cancelDialog(string $id)
    {
        $this->modal = false;
        $this->dialog()->confirm([
            'title' => "Cancelar a venda #{$this->sale_detail['id']}",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja cancelar esta compra?",
            'accept' => [
                'label' => 'Cancelar',
                'method' => 'cancelSale',
                'params' => $id,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Fechar',
                'color' => 'info',
            ],
        ]);
        $this->mount();
    }

    public function cancelSale($id) : void
    {
       OrderController::destroy($id);
    }

    public function confirmSale($id)
    {
        $sale = Sale::find($id);
        $sale->payment_status = 1;
        $sale->save();
        $this->mount();
    }

    public function render()
    {
        $sales = Sale::latest("id")->where('payment_status', 'LIKE', '1')->paginate(10);

        return view('admin.reports', [
            'sales' => $sales,
        ]);

    }
}
