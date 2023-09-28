<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Reports extends Component
{
    use WithPagination;
    use Actions;

    public $total = 0;
    public $unconfirmedSale = [];


    public function mount(){

          $this->unconfirmedSale = Sale::where('payment_status', 'LIKE', '0')->get()->sortByDesc('id');
        $this->total = 0;
        foreach ($this->unconfirmedSale as $item) {
            if ($item->payment_status == 0) {
                $this->total = $this->total + $item->price;
            }
        }
    }



    public function confirmSale($id){
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
