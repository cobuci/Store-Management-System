<?php

namespace App\Livewire\Pages;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use WireUi\Traits\Actions;

class CustomerRegister extends Component
{
    use Actions;

    public array $customer = [
        'name' => '',
        'gender' => '',
        'phone' => '',
        'email' => '',
        'street' => '',
        'number' => '',
        'district' => '',
    ];

    public string $zip_code = '';


    protected array $rules = [
        'customer.name' => 'required|string|max:50',
        'customer.phone' => 'nullable|string|max:16',
        'customer.email' => 'nullable|email|max:60',
        'customer.street' => 'nullable|string|max:60',
        'customer.number' => 'nullable|string|max:10',
        'customer.district' => 'nullable|string|max:60',
        'zip_code' => 'nullable|string|max:11',
    ];

    protected array $messages =[
            'customer.name.required' => 'O campo está em branco.',
            'content.max' => 'The  is too short.',
    ];

    public function save(): void
    {
        $this->validate();

        Customer::create(
            [
                'name' => $this->customer['name'],
                'phone' => $this->customer['phone'],
                'gender' => $this->customer['gender'],
                'zipcode' => $this->zip_code,
                'street' => $this->customer['street'],
                'number' => $this->customer['number'],
                'district' => $this->customer['district'],
                'email' => $this->customer['email'],
            ]
        );
        $this->reset();
        $this->notification()->success(
            $title = 'Cliente cadastrado com sucesso',
            $description = 'O cliente foi cadastrado com sucesso',
        );
    }

    public function updatedZipCode(): void
    {
        $response = Http::get('https://viacep.com.br/ws/' . $this->zip_code . '/json/')->json();
        $this->customer['street'] = $response['logradouro'];
        $this->customer['district'] = $response['bairro'];
    }

    public function render(): View|Application
    {
        return view('admin.customer_register');
    }
}
