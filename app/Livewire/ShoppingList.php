<?php

namespace App\Livewire;

use http\Params;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\{Models\ShoppingList as Shopping};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class ShoppingList extends Component
{
    use Actions;

    public Collection $list;
    public string $total;

    public string $product = '';
    public string $amount = '';
    public string $cost = '';
    public string $fee = '';

    protected array $rules = [
        'product' => ['required'],
        'amount' => ['required'],
        'cost' => ['required'],
        'fee' => ['nullable'],
    ];

    protected array $messages = [
        'product.required' => 'O campo Produto é obrigatorio',
        'amount.required' => 'O campo Quantidade é obrigatorio',
        'cost.required' => 'O campo Custo é obrigatorio',
    ];

    public function deleteDialog(string $id): void
    {
        $product = Shopping::find($id);
        $this->dialog()->confirm([
            'title' => "{$product?->amount}x - {$product?->product}",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja excluir o produto da lista de compras?",
            'accept' => [
                'label' => 'Excluir',
                'method' => 'delete',
                'params' => $id,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'info',
            ],
        ]);

    }

    public function delete($id)
    {
        Shopping::find($id)?->delete();
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->list = Shopping::all();
        $this->total = $this->calculateTotal();


        return view('admin.shoppingList');
    }

    public function calculateTotal(): string
    {
        $total = Shopping::select(DB::raw('SUM(final_price * amount) as total'))->value('total');

        return number_format($total, 2);
    }

    public function store(): void
    {
        $this->validate();

        $this->fee == null ? $this->fee = 0 : null;
        $cost = $this->cost;
        $fee = $this->fee;
        $final_price = $cost + ($cost * ($fee / 100));

        Shopping::updateOrCreate([
            'product' => $this->product,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'fee' => $this->fee,
            'final_price' => $final_price
        ]);


        $this->notification()->success(
            title: 'Produto adicionado a lista',
            description: "Você adicionou $this->amount $this->product à lista."
        );
        $this->reset();
    }

}
