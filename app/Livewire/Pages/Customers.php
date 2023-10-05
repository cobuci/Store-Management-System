<?php

namespace App\Livewire\Pages;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->mount();
    }

    public function mount()
    {
    }

    public function customerProfile($id)
    {
        return redirect()->route('admin.customer.profile', $id);
    }


    public function render()
    {
        if (!$this->search) {
            $customers =   Customer::orderBy('name','asc')->paginate(10);
        } else {
            $customers = Customer::where('name', 'LIKE', "%{$this->search}%")->orderBy('name','asc') ->paginate(10);
        }
        return view('admin.customer', compact('customers'));
    }
}
