<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWalletRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'principal_amount' => 'required',
            'total_amount' => 'required',
            'restrictions' => 'required',
            'bank_name' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:2048',
            'status' => 'required|string',
        ];
    }
}
