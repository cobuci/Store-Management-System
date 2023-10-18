<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\PurchaseController;
use App\Models\Purchase as PurchaseModel;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Purchase extends Component
{
    use Actions;
    use WithPagination;

    public $unpaidPurchases = [];

    public array $costs = [
        'total' => 0,
        'thisMonth' => 0,
        'expired' => 0,
    ];


    public function payPurchase($id)
    {
        $purchase = PurchaseModel::find($id);
        $purchase->payment_status = 1;
        $purchase->save();
        $this->mount();
    }

    public function mount()
    {
        $this->unpaidPurchases = PurchaseModel::where('payment_status', 0)->orderBy('expiration_date', 'asc')->get();

        $this->costs = [
            'total' => PurchaseController::unpaidPurchases(),
            'thisMonth' => PurchaseController::unpaidPurchasesThisMonth(),
            'expired' => PurchaseController::unpaidPurchasesExpired(),
        ];


    }


    public function dialogPay($id)
    {
        $this->dialog()->confirm([
            'title' => 'Confirmar o pagamento',
            'description' => 'Deseja confirmar o pagamento?',
            'acceptLabel' => 'Confirmar',
            'method' => 'payPurchase',
            'params' => $id,
        ]);
    }

    public function cancelPurchase($id)
    {
        PurchaseController::destroy($id);
        $this->mount();
    }

    public function dialogCancel($id)
    {
        $this->dialog()->confirm([
            'title' => 'Cancelar a compra',
            'description' => 'Deseja cancelar a compra?',
            'acceptLabel' => 'Cancelar',
            'method' => 'cancelPurchase',
            'params' => $id,
        ]);
    }


    public function render()
    {

        $paidPurchases = PurchaseModel::
        where('payment_status', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.purchase', compact('paidPurchases'));
    }
}
