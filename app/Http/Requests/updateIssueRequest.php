<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateIssueRequest extends FormRequest
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
            'number' => 'required_with:year|nullable|numeric',
            'year' => 'required_with:number|nullable|numeric',
            'adv_number' => 'required_with:adv_year|nullable|numeric',
            'adv_year' => 'required_with:adv_number|nullable|numeric',
            'subject' => 'required|string',
            'court' => 'nullable|string',
            'room' => 'nullable|string'
        ];
    }
}
