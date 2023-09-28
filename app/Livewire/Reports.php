<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;

class Reports extends Component
{

    public $confirmedSale = [];
    public $total = 0;
    public $unconfirmedSale = [];


    public function mount(){
        $this->confirmedSale = Sale::where('payment_status', 'LIKE', '1')->get();
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
        return view('admin.reports');
    }
}
