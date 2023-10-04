<?php

namespace App\Livewire\Pages;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use WireUi\Traits\Actions;

class CustomerRegister extends Component
{
    use Actions;


    public $name = '';
    public $phone = '';
    public $address = '';

    public $gender = '';
    public $zip_code = '';
    public $street = '';
    public $number = '';
    public $district = '';
    public $mail = '';

    protected array $rules = [
        'name' => 'required',
    ];

    public function save()
    {
        $this->validate();
        Customer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'zipcode' => $this->zip_code,
                'street' => $this->street,
                'number' => $this->number,
                'district' => $this->district,
                'email' => $this->mail,
            ]
        );
        $this->reset();
        $this->notification()->success(
            $title = 'Cliente cadastrado com sucesso',
            $description = 'O cliente foi cadastrado com sucesso',
        );

    }

    public function updatedPhone()
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
        $this->phone = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->phone);
    }

    public function updatedZipCode()
    {
        $response = Http::get('https://viacep.com.br/ws/' . $this->zip_code . '/json/')->json();
        $this->street = $response['logradouro'];
        $this->district = $response['bairro'];
    }


    public function render()
    {
        return view('admin.customer_register');
    }
}
