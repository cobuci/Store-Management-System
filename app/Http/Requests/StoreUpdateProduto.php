<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProduto extends FormRequest
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
        $rules = [
            'nome' => [
                'nullable',
                'string',
            ],
            'marca' => [
                'nullable',
                'string',
            ],
            'peso' => [
                'nullable',
                'string',
            ],
            'id_categoria' => [
                'nullable',
                'integer',
            ],
            'custo' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'venda' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'quantidade' => [
                'nullable',
                'integer',
            ],
            'validade' => [
                'nullable',
                'date',
            ],
        ];

       
        return $rules;
    }

}
