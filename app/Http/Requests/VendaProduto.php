<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendaProduto extends FormRequest
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
            'id_produto' => [
                'nullable',
                'integer',
            ],
            'produto' => [
                'required',
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
            'quantidade' => [
                'required',
                'integer',
            ],
            'custo' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'precoUnidade' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'desconto' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'precoVenda' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'id_cliente' => [
                'nullable',
                'integer',
            ],
            'nomeCliente' => [
                'nullable',
                'string',
            ],
            'formaPagamento' => [
                'nullable',
                'string',
            ], 'created_at' => [
                'nullable',
                'timestamp',
            ],
        ];
    }
}
