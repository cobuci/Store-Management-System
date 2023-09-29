<?php

namespace App\Livewire;

use App\Http\Controllers\OrderController;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Sale;
use WireUi\Traits\Actions;

class CustomerProfile extends Component
{
    use Actions;
    public $customer = [];
    public $unconfirmedSale = [];
    public $confirmedSale = [];
    public $modal = false;
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


    public function mount($id)
    {
        $this->customer = Customer::find($id)->toArray();
        $this->customer['debits'] = Customer::find($id)->debit();
        $this->customer['spent'] = Customer::find($id)->spent();
        $this->customer['water'] = Customer::find($id)->water();
        $this->unconfirmedSale = Customer::find($id)->unconfirmedSale()->get()->sortByDesc('id');
        $this->confirmedSale = Customer::find($id)->confirmedSale()->get()->sortByDesc('id');
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
        $this->mount($this->customer['id']);
    }
    

    public function cancelSale($id): void
    {
        OrderController::destroy($id);
        $this->mount($this->customer['id']);
    }

    public function confirmSale($id)
    {
        $sale = Sale::find($id);
        $sale->payment_status = 1;
        $sale->save();
        $this->mount($this->customer['id']);
    }
    public function update()
    {
        $this->validate([
            'customer.name' => 'required',
        ]);

        Customer::find($this->customer['id'])->update($this->customer);

        $this->mount($this->customer['id']);
        $this->notification()->success('Cliente atualizado com sucesso!');
    }

    public function deleteModal()
    {
        $this->dialog()->confirm([
            'title' => "Deletar Cliente",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja excluir o cliente: {$this->customer['name']}?",
            'accept' => [
                'label' => 'Excluir',
                'method' => 'delete',
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'info',
            ],
        ]);
    }

    public function delete()
    {
        Customer::find($this->customer['id'])->delete();
        $this->notification()->success('Cliente deletado com sucesso!');
        return redirect()->route('admin.customer');
    }

    public function render()
    {




        return view('admin.customer_profile');
    }
}
