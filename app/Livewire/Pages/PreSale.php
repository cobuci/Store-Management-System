<?php

namespace App\Livewire\Pages;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PreSale extends Component
{

    public  $sales;
    public $urlApi;

    public function getSales()
    {
        try {
            $response = Http::get($this->urlApi)->json();

            foreach ($response as $sale) {
                $sale['items'] = $this->getItems($sale['id']);
                $sale['date'] = Carbon::createFromTimestamp(
                    $sale['created']['_seconds']
                )->format('d-m-Y');
                $sale['updated'] = Carbon::createFromTimestamp(
                    $sale['updated_at']['_seconds']
                )->format('d-m-Y');
                $this->sales[] = $sale;
            }
        } catch (\Exception $e) {
            $this->sales = [];
        }
    }

    public function getItems($id)
    {
        try {
            $response = Http::get($this->urlApi . '/' . $id)->json();
            return $response;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function mount()
    {
        $this->urlApi = env('API_FIREBASE_URL');
        $this->getSales();
    }


    public function render()
    {
        return view('admin.pages.pre-sale');
    }
}
