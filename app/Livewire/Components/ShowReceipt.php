<?php

namespace App\Livewire\Components;

use App\Models\ReceiptList;
use Livewire\Component;

class ShowReceipt extends Component
{
    public $products = [];
    public $receipt;

    public function mount($id): void
    {
        $this->receipt = ReceiptList::find($id);
        $this->products = $this->receipt->items->sortByDesc('active');
    }

    public function productActive($id)
    {
        $product = $this->receipt->items()->find($id);
        $product->active = !$product->active;
        $product->save();

        $this->mount($this->receipt->id);
    }

    public function render()
    {
        return view('admin.components.show-receipt');
    }
}
