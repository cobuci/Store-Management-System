<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Session;
use Livewire\Component;
use WireUi\Traits\Actions;

class PreSaleItem extends Component
{
    use Actions;

    public $sale;
    public bool $cardModal = false;


    public function mount()
    {
    }

    public function openModal(): void
    {
        $this->cardModal = true;
    }

    public function continueOrder()
    {
        Session::flash('sale', $this->sale['items']);
        redirect()->route('admin.sale');
    }


    public function render()
    {
        return view('admin.components.pre-sale-item');
    }
}
