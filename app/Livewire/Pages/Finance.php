<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\CashierController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InvestimentController;
use App\Http\Controllers\PurchaseController;
use App\Models\{Finance as FinanceModel, Sale};
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Finance extends Component
{

    use WithPagination;
    use Actions;

    public string $balance = '';

    public string $due = '';
    public $value_unpaid_purchases = '';
    public $modalBalanceOptions = false;
    public $modalBalanceAdd = false;
    public $value_balance_add = '';

    public $modalBalanceRemove = false;
    public $value_balance_remove = '';


    public function dialogCancel($id)
    {
        $this->dialog()->confirm([
            'title' => "Cancelar a compra",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja cancelar?",
            'accept' => [
                'label' => 'Excluir',
                'method' => 'cancelFinance',
                'params' => $id,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'info',
            ],
        ]);

    }

    public function cancelFinance($id)
    {
        FinanceController::destroy($id);
        $this->mount();
    }

    public function mount()
    {
        $this->balance = CashierController::balance();
        $this->due = Sale::totalDue();
        $this->value_unpaid_purchases = PurchaseController::unpaidPurchases();
    }

    public function showBalanceOptions()
    {
        $this->modalBalanceOptions = true;
    }

    public function showAddBalance()
    {
        $this->modalBalanceOptions = false;
        $this->modalBalanceAdd = true;
    }

    public function addBalance()
    {
        $this->validate([
            'value_balance_add' => 'required|numeric',
        ]);
        InvestimentController::addBalance($this->value_balance_add, "Adicionado saldo");

        $this->reset('value_balance_add');
        $this->mount();
        $this->modalBalanceAdd = false;
        $this->notification()->success(
            title: 'Valor adicionado com sucesso!',
        );
    }

    public function showRemoveBalance()
    {
        $this->modalBalanceOptions = false;
        $this->modalBalanceRemove = true;
    }

    public function withdrawBalance()
    {
        $this->validate([
            'value_balance_remove' => 'required|numeric',
        ]);
        InvestimentController::withdrawBalance($this->value_balance_remove, "Resgate de saldo", date('d-m-Y'));

        $this->reset('value_balance_remove');
        $this->mount();
        $this->modalBalanceRemove = false;
        $this->notification()->success(
            title: 'Valor Resgatado com sucesso!',
        );
    }


    public function render()
    {
        $finances = FinanceModel::latest("id")->paginate(10);
        return view('admin.finances', compact('finances'));
    }
}
