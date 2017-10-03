<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeContractRequest extends FormRequest
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
            'number' => 'required|integer',
            'year' => 'required|integer|min:4',
            'letter' => 'required',
            'type' => 'required|integer',
            'office' => 'required|string',
            'archive_number' => 'nullable|integer',
            'people' => 'required'
        ];
    }
}
