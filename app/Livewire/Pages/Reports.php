<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\OrderController;
use App\Models\Sale;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Reports extends Component
{
    use WithPagination;
    use Actions;

    public $search = '';
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

    public function updatedSearch()
    {
        $this->mount();
    }

    public function mount()
    {
        if (!$this->search) {
            $this->unconfirmedSale = Sale::where('payment_status', 'LIKE', '0')->get()->sortByDesc('id');
        } else {
            $this->unconfirmedSale = Sale::where('payment_status', 'LIKE', '0')->where('customer_name', 'LIKE', "%{$this->search}%")->get()->sortByDesc('id');
        }

        $this->total = Sale::totalDue();
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
    }

    public function confirmDialog(string $id){
        $this->dialog()->confirm([
            'title' => "Confirmar o pagamendo da Venda #{$this->sale_detail['id']}",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja confirmar o pagamento da Venda?",
            'accept' => [
                'label' => 'Confirmar',
                'method' => 'confirmSale',
                'params' => $id,
                'color' => 'positive',
            ],
            'reject' => [
                'label' => 'Fechar',
                'color' => 'negative',
            ],
        ]);
    }

    public function cancelSale($id): void
    {
        OrderController::destroy($id);
        $this->mount();
    }


    public function confirmSale($id)
    {
        $sale = Sale::find($id);
        $sale->payment_status = 1;
        $sale->save();
        Cache::forget('balance');
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
