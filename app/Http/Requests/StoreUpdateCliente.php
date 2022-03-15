<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCliente extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => [
                'required',
                'string',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'sexo' => [
                'nullable',
                'string',
            ],
            'cep' => [
                'nullable',
                'string',
            ],
            'rua' => [
                'nullable',
                'string',
            ],
            'numero' => [
                'nullable',
                'string',
            ],
            'bairro' => [
                'nullable',
                'string',
            ],
        ];
    }
}
