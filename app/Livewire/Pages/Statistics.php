<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use DB;
use Livewire\Component;

class Statistics extends Component
{

    public $date = [
        'start' => '',
        'end' => '',
    ];


    public function updatedDate()
    {

        $firstSale = Sale::orderBy('created_at', 'asc')->first();
        if (empty($this->date['start'])) {
            $this->date['start'] = $firstSale?->created_at->toDateString() ?? date('Y-m-d');
        }
        if (empty($this->date['end'])) {
            $this->date['end'] = date('Y-m-d', strtotime('+1 day'));
        }

        $this->dispatch('dateUpdated', $this->date);
    }

    public function render()
    {

        return view('admin.tool_statistics');
    }
}
