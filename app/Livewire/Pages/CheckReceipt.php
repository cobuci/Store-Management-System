<?php

namespace App\Livewire\Pages;

use App\Models\ReceiptList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CheckReceipt extends Component
{
    public $receipts = [];

    public string $receiptKey = '';
    public string $receiptName = '';

    public $items = [];
    public string $httpCode = '';


    public function newReceipt(): void
    {
        $this->validate([
            'receiptKey' => 'required|min:30',
            'receiptName' => 'required',
        ]);

        $this->getItems();

        if ($this->httpCode == 200) {
            $receiptList = ReceiptList::create([
                'key' => $this->receiptKey,
                'name' => $this->receiptName,
            ]);

            $id_receiptList = $receiptList->id;

            foreach ($this->items as $item) {
                $receiptList->items()->create([
                    'name' => $item['descricao'],
                    'cod' => $item['codigo'],
                    'amount' => $item['quantidade'],
                    'active' => true,
                    'price' => $item['valor_unitario'],
                    'total' => $item['valor_total_item'],
                    'receipt_list_id' => $id_receiptList,
                ]);
            }

            $this->mount();
        }
    }


    public function getItems(): void
    {
        $token = env('API_INFOSIMPLES_TOKEN');
        $response = Http::get('https://api.infosimples.com/api/v2/consultas/sefaz/sp/cfe?token=' . $token . '-em&timeout=600&chave=' . $this->receiptKey)->json();

        if ($response['code'] == 200) {
            $this->items = $response['data'][0]['produtos'];
        }
        $this->httpCode = $response['code'];
    }


    public function showReceipt($id): Redirector| RedirectResponse
    {
        return redirect()->route('admin.tool.show-receipt', $id);
    }

    public function mount(): void
    {
        $this->receipts = ReceiptList::all();
    }



    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admin.check-receipt');
    }
}
