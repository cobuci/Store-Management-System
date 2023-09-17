<?php

namespace App\Livewire;

use App\Models\ShoppingList as Shopping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShoppingList extends Component
{

    public Collection $list;
    public string $total;

    public string $product = '';
    public string $amount = '';
    public string $cost = '';

    protected array $rules = [
        'product' => ['required'],
        'amount' => ['required'],
        'cost' => ['required'],
    ];

    protected array $messages = [
        'product.required' => 'O campo Produto é obrigatorio',
        'amount.required' => 'O campo Quantidade é obrigatorio',
        'cost.required' => 'O campo Custo é obrigatorio',
    ];

    public function delete(string $id)
    {
        Shopping::find($id)?->delete();
    }


    public function render()
    {
        $this->list = Shopping::all();
        $this->total = $this->calculateTotal();

        return view('admin.shoppingList');
    }

    public function calculateTotal(): string
    {
        $total = Shopping::select(DB::raw('SUM(amount * cost) as total'))->value('total');

        return number_format($total, 2);
    }

    public function store(): void
    {
        $this->validate();

        Shopping::updateOrCreate([
            'product' => $this->product,
            'amount' => $this->amount,
            'cost' => $this->cost,
        ]);
        $this->reset();
        $this->render();
    }

    public function mount(): void
    {


    }
}
