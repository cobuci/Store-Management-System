<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;

class Inventory extends Component
{
    use Actions;
    public $products = [];
    public $categories = [];
    public $list = [];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function deleteDialog(string $id): void
    {
        $product = Product::find($id);
        $this->dialog()->confirm([
            'title' => "#{$product->id} - {$product?->name}  ({$product?->weight}) - {$product?->brand} ",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja excluir o produto do estoque?",
            'accept' => [
                'label' => 'Excluir',
                'method' => 'deleteProduct',
                'params' => $id,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'info',
            ],
        ]);

    }
    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        $this->notification()->success('Produto excluído com sucesso!');
    }

    public function render()
    {
        return view('admin.inventory');
    }
}
