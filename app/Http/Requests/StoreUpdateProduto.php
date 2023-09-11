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
            'name' => [             
                'string',
            ],
            'brand' => [
                'nullable',
                'string',
            ],
            'weight' => [
                'nullable',
                'string',
            ],
            'category_id' => [
                'nullable',
                'integer',
            ],
            'cost' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'sale' => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'amount' => [
                'nullable',
                'integer',
            ],
            'expiration_date' => [
                'nullable',
                'date',
            ],
        ];

       
        return $rules;
    }

}
